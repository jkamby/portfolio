// This #include statement was automatically added by the Particle IDE.
#include <RelayShield.h>

/*
 * Custom code to run a 4-switch relay shield
 * @author JPK
 * @version 2.0
 * @name jpkrelayshield.ino
 *
 *
 */
 
RelayShield jpkRelays;

int rDuration[5] = {-1, -1, -1, -1, -1};            // initializing the duration parameter for all relays
int rInterval[5] = {-1, -1, -1, -1, -1};            // initializing the interval parameter for all relays
int rCount[5] = {0, 0, 0, 0, 0};                    // initializing the count parameter for all relays, used to handle one-off's
uint32_t rNow[5] = {0, 0, 0, 0, 0};                 // initializing the now parameter (a relative temporal notion) for all relays 
bool rBusy[5] = {false, false, false, false, false};   // initializing the busy parameter for all relays

void setup() {
    // initializing the relays to use relayShield lib
    jpkRelays.begin();
    
    // function to handle REST call
    Particle.function("relay", handleCall);
    
    // function to RESTfully check for relay status
    // Particle.function("status", busyCheck);
    
    // publishing the status of the relays
    Particle.variable("rBusy1", rBusy[1]);
    Particle.variable("rBusy2", rBusy[2]);
    Particle.variable("rBusy3", rBusy[3]);
    Particle.variable("rBusy4", rBusy[4]);

    // TODO: function to send out REST call once an instruction is complete
    
}

void loop() {
    
    // keeps executing any change in status for a relay
    relayIdling(1);
    relayIdling(2);
    relayIdling(3);
    relayIdling(4);

}

/*bool [] busyCheck() {
    return rBusy;
}*/

//function to handle input from the REST call/form submission
int handleCall(String incomingData) {
  // Supports 3 strings:
  // "t:relay#,sec,min;"    Runs sec seconds every min minutes on relay#
  // "c:relay#,sec;"        Runs a one-ff for sec seconds on relay#
  // "x:[relay#];"          Cancels current run on relay# or all relays if left blank -- TODO.
  
  char cmd=0x00;    //  [tcx]
  int curIdx=0;
  int relayNum;    //  [1234]
  int exitStatus = 0;
  char secStr[16];  //  [0...99999] - up to 1 day
  char minStr[16];  //  [0...99999] - up to 1 month
  
  //parse incomingData
  curIdx=0;
  cmd=incomingData.charAt(curIdx);    //get cmd char
  curIdx=2;
  relayNum=(int)incomingData.charAt(curIdx) - 48; // get relayNum (less ASCII 0 = 48)
  curIdx=4;   //skip cmd, :, relay# and ,
  
  switch (cmd)
  {
    case 'x':
      exitStatus = stopRelay(relayNum);
      break;

    case 'c':
      curIdx=getNextVal(incomingData,curIdx,';',secStr);     //get second ; term
      if(rDuration[relayNum] == -1) { // prevents interruption of busy relay
          rDuration[relayNum] = atoi(secStr);
          exitStatus = 1;
      } else { exitStatus = 2; /*rBusy[relayNum] = true;*/ }
      break;

    case 't':
      //timer1
      curIdx=getNextVal(incomingData,curIdx,',',secStr);     //get second , term
      curIdx=getNextVal(incomingData,curIdx,';',minStr);     //get min ; term
      if(rDuration[relayNum] == -1) { // prevents interruption of busy relay
          rDuration[relayNum] = atoi(secStr);
          rInterval[relayNum] = atoi(minStr);
          exitStatus = 1;
      } else { exitStatus = 2; /*rBusy[relayNum] = true;*/ }
      break;
  }
  
  return exitStatus;
}

// function to respond to the change in a relay's parameters
void relayIdling(int r) {
    if(rDuration[r] != -1) {  // if a duration value has been submitted...
        if(millis() > (rNow[r] + rDuration[r] * 1000)) { // setting up the timing mechanism
            if(rCount[r] == 0) { // ensures one run of this code block
                rNow[r] = millis(); // calibrating the relay's temporal frame of ref
                jpkRelays.on(r);
                rBusy[r] = true;
                rCount[r]++; // increment the cycle count
            } else { // this is not the first run, i.e. the first run has completed
                if(jpkRelays.isOn(r) == true) { 
                    jpkRelays.off(r); 
                }
                if(rInterval[r] != -1) { // if an interval was submitted, i.e. it is an autonomous run...
                    if(millis() > (rNow[r] + rInterval[r] * 60000)) { // is it time to repeat the cycle?
                        rNow[r] = millis();
                        if(jpkRelays.isOn(r) == false) jpkRelays.on(r);
                    }
                    rCount[r]++; // increment the cycle count
                } else { // else interval was not set and this is a one-ff
                    stopRelay(r);
                    // rDuration[r] = -1;
                    // rCount[r] = 0;
                    // rNow[r] = 0;
                }
            }
            
        } // else the relay is still running, check back again shortly
        
    } // else continue to idle/do nothing
    
}

// StopRelay Helper function
int stopRelay(int relayNo) {
    if(relayNo != 9) { // cludge to respond to cancelAll
        jpkRelays.off(relayNo);
        rDuration[relayNo] = -1;
        rInterval[relayNo] = -1;
        rCount[relayNo] = 0;
        rNow[relayNo] = 0;
        rBusy[relayNo] = false;
        return relayNo + 10;
    } else {
        jpkRelays.allOff();
        for (int j = 0; j < 5; j++) {
            rDuration[j] = -1;
            rInterval[j] = -1;
            rCount[j] = 0;
            rNow[j] = 0;
            rBusy[j] = false;
        }
        return 15;
    }
}

// parse input Helper function
int getNextVal(String data, int off, char term, char *val)
{
  //given a String and a beginning offset and a terminator character, returns the val as a char *,
  //and returns the idx of the NEXT offset (skipping the terminator)
  //if return val -1, not found

  int endOff;
  String valStr;

  //find next terminator char
  endOff=data.indexOf(term,off);
  if (endOff == -1)
  {
    return -1;
  }
  //copy string and convert to char *
  valStr=data.substring(off,endOff);
  valStr.toCharArray(val,valStr.length()+1);    //add 1 for null term
  return endOff+1;
}
