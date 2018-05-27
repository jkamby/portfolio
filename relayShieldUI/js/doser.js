var forms = document.querySelectorAll("form");

for( i = 1; i <= forms.length; i++) {
  const TANKNUM = i;
  let targetForm = document.querySelector("#tank" + TANKNUM);
  let targetLog = document.querySelector("#log" + TANKNUM);

  targetForm.addEventListener("submit", function(event) {
    let data = new FormData(targetForm);
    let output = "";
    let argout = "";
    for (const entry of data) {
      if(entry[1] === "auto")
        argout += "t:" + TANKNUM + ",";
      else if(entry[1] === "manual")
        argout += "c:" + TANKNUM + ",";
      output += entry[0] + "=" + entry[1] + "\t";
      if(entry[0] === "duration"){
        argout += entry[1];
        if(argout[0] === "c") {
          argout += ";";
        }
      } else if(entry[0] === "interval" && argout[0] === "t")
        argout += "," + entry[1] + ";";
    }
    output += "arg=" + argout;
    data.append("arg", argout);
    targetLog.innerText = output;
    event.preventDefault();
    
    let newData = new FormData();
    
    fetch('https://api.particle.io/v1/devices/350042000e51353532343635/tank?access_token=8db83ede2e5eb5b0047413935c796aaf9ab165ff',
          { method: 'POST',
           mode: 'no-cors',
           body: JSON.stringify(data),
           headers: new Headers({ 'Content-Type': 'application/json' })
    }).then(res => res.json()).catch(error => console.error('Error:', error)).then(response => console.log('Success:', response));
    
  });
  
}
