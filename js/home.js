window.onload = function() {
    let p = document.querySelector("#typing-text");
    let text = "First solve the problem. Then, Write the code.";
    typeWriter(p, text, 0);
  };
  
  function typeWriter(p, text, i) {
    if (i < text.length) {
      p.innerHTML += text.charAt(i);
      i++;
      setTimeout(function() { typeWriter(p, text, i); }, 50);
    }
  }