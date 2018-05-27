/*
 * Custom JS code to run the front-end UI for the RelayShield
 * @author JPK
 * @version 2.1
 *
 */

// capture up to 4 forms
var forms = document.querySelectorAll("form");

// submit & cancel all
var submitAllButton = document.querySelector("#submitAll");

// add an event listener on each form
for (i = 1; i <= forms.length; i++) {
  const RELAYNUM = i;
  let targetForm = document.querySelector("#tank" + RELAYNUM);
  let targetLog = document.querySelector("#log" + RELAYNUM);

  if (targetForm) {

  var prodding = (RELAYNUM, sText = '') => {

	let prodTargetForm = document.querySelector("#tank" + RELAYNUM);
	let prodTargetLog = document.querySelector("#log" + RELAYNUM);
	let prodDevID = document.querySelector("#device" + RELAYNUM).value;
	let prodToken = document.querySelector("#token" + RELAYNUM).value;


	 // the intermittent cancel button
	let theCancelButton = '<button type="button" onclick="cancelRun(' + RELAYNUM + ', \'' + prodDevID + '\',\'' + prodToken + '\');">Cancel!</button>';

	// prodding the RS for status
      fetch(
        "https:\/\/api.particle.io/v1/devices/" +
          prodDevID + 
          "/rBusy" + RELAYNUM + "?access_token=" +
          prodToken + "&format=raw"
      )
         .then(response => response.text()
		 .then(text => { 
				if (text == 'true') {
					prodTargetLog.textContent = "Status: busy" + sText + ", please wait or ";
					disable_form(prodTargetForm);
					prodTargetLog.insertAdjacentHTML("beforeend", theCancelButton);
				} else if (text == 'false') {
					prodTargetLog.textContent = "Status: idle.";
					enable_form(prodTargetForm);
				} else {
					prodTargetLog.textContent = "Status: connection failure!!!";
				}
				})
	)
         .catch(error => console.error("Error:", error));
  };

  prodding(RELAYNUM);

    //onsubmit event listener
    targetForm.addEventListener("submit", function(event) {
      let data = new FormData(targetForm);
      let output = " [";
      let deviceID = "";
      let access_token = "";
      let prodInterval = 0;

      // format data for submission and for the status bar
      for (const entry of data) {
        if (entry[0] === "device") deviceID = entry[1];
        if (entry[0] === "token") access_token = entry[1];
        if (entry[1] === "auto") {
          data.arg = "t:" + RELAYNUM + ",";
          output += "(" + entry[1] + ") ";
        } else if (entry[1] === "manual") {
          data.arg = "c:" + RELAYNUM + ",";
          output += "(" + entry[1] + ") ";
        }

        if (entry[0] === "duration") {
          data.arg += entry[1];
          output += entry[1] + " second" + (entry[1] > 1 ? "s" : "");
	  prodInterval = (parseInt(entry[1]))*1000;
          if (data.arg[0] === "c") {
            data.arg += ";";
            output += "]";
          }
        } else if (entry[0] === "_interval" && data.arg[0] === "t") {
          data.arg += "," + entry[1] + ";";
          output +=
            " every " + entry[1] + " minute" + (entry[1] > 1 ? "s" : "") + "]";
        }
      }

     event.preventDefault();

      // on-submit
      fetch(
        "https:\/\/api.particle.io/v1/devices/" +
          deviceID +
          "/relay?access_token=" +
          access_token,
        {
          method: "POST",
          mode: "cors",
          body: JSON.stringify(data),
          headers: new Headers({ "Content-Type": "application/json" })
        }
      )
        .then(res => res.json())
        .catch(error => console.error("Error:", error))
        .then(response => {
          targetForm.reset();
          prevPage(RELAYNUM);
        })
	.then( response => prodding(RELAYNUM, output) )
	.then( response => setTimeout(() => prodding(RELAYNUM), prodInterval) );
    });
  } else {
    // console.log("targetForm is null!");
  }


}

// "paginates" the form, shows next form page
function nextPage(z) {
  document.getElementById("radios" + z).style.display = "none";
  if (document.getElementById("tank" + z)["automan"].value == "auto") {
    document.getElementById("not_auto_" + z).className = "auto";
    document.getElementById("_interval" + z).required = true;
  } else {
    document.getElementById("not_auto_" + z).className = "not_auto";
    document.getElementById("_interval" + z).required = false;
  }
  document.getElementById("details" + z).style.display = "inline-block";
}

// shows previous form page
function prevPage(z) {
  document.getElementById("radios" + z).style.display = "inline-block";
  document.getElementById("details" + z).style.display = "none";
  document.querySelector("#log" + z).textContent = "Status: Run cancelled.";
}


// cancels an auto run
function cancelRun(r, devID, aToken) {
  // let deviceId =  - make cancelRun a part of the eventListener. TODO.
  fetch(
    "https:\/\/api.particle.io/v1/devices/" + devID + "/relay?access_token=" + aToken,
    {
      method: "POST",
      mode: "cors",
      body: JSON.stringify({ arg: "x:" + r + ";" }),
      headers: new Headers({ "Content-Type": "application/json" })
    }
  )
    .then(res => res.json())
    .then(response => prevPage(r))
    .then(response => prodding(r))
    .catch(error => console.error("Error:", error));
}


// cancels all runs
function cancelAll(devID, aToken, relays) {
  // let deviceId =  - make cancelRun a part of the eventListener. TODO.
  fetch(
    "https://api.particle.io/v1/devices/" + devID + "/relay?access_token=" + aToken,
    {
      method: "POST",
      mode: "cors",
      body: JSON.stringify({ arg: "x:9;" }),
      headers: new Headers({ "Content-Type": "application/json" })
    }
  )
    .then(res => res.json())
    .then(res => prevPages(relays))
    .catch(error => console.error("Error:", error));
//  prevPages(relays);
  // document.querySelector("#log" + r).textContent = "Status: Run cancelled.";
}

// shows previous form pages
function prevPages(z) {
  for (k = 1; k <= z; k++) {
    document.getElementById("radios" + k).style.display = "inline-block";
    document.getElementById("details" + k).style.display = "none";
    document.querySelector("#log" + k).textContent = "Status: Run cancelled.";
    prodding(k);
  }
}

// The polling function
function poll(fn, timeout, interval) {
  var dfd = new Deferred();
  var endTime = Number(new Date()) + (timeout || 2000);
  interval = interval || 100;

  (function p() {
    // If the condition is met, we're done!
    if (fn()) {
      dfd.resolve();
    }
    // If the condition isn't met but the timeout hasn't elapsed, go again
    else if (Number(new Date()) < endTime) {
      setTimeout(p, interval);
    }
    // Didn't match and too much time, reject!
    else {
      dfd.reject(new Error('timed out for ' + fn + ': ' + arguments));
    }
  })();

  return dfd.promise;
}

/*
 * Disables and enables every input, textarea, button and select elements inside
 * a form-element.
 *
 * Enhanced by JPK (Originally by Magnus Fredlundh)
 */

// Disables a form.
function disable_form(form) {
  var inputs = form.getElementsByTagName('input'),
      textareas = form.getElementsByTagName('textarea'),
      buttons = form.getElementsByTagName('button'),
      selects = form.getElementsByTagName('select');

  disable_elements(inputs);
  disable_elements(textareas);
  disable_elements(buttons);
  disable_elements(selects);
}

// Disables a collection of form-elements.
function disable_elements(elements) {
  var length = elements.length;
  while(length--) {
    elements[length].disabled = true;
  }
}

// Enables a (previously disabled) form.
function enable_form(form) {
  var inputs = form.getElementsByTagName('input'),
      textareas = form.getElementsByTagName('textarea'),
      buttons = form.getElementsByTagName('button'),
      selects = form.getElementsByTagName('select');

  enable_elements(inputs);
  enable_elements(textareas);
  enable_elements(buttons);
  enable_elements(selects);
}

// Enables a collection of form-elements.
function enable_elements(elements) {
  var length = elements.length;
  while(length--) {
    elements[length].disabled = false;
  }
}
