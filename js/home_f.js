window.onload = function() {
    let p = document.querySelector("#typing-text");
    let text = "First solve the problem. Then, Write the code.";
    typeWriter(p, text, 0);

  // Create an intersection observer instance
  const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      // The target element is now visible, do something here
      let text = " is to transfer experiences among students and develop the concept of programming through competitive programming and problem-solving training. Our first goal is to create a programmer who is able to think, not a programmer who is able to memorize.";
      typeWriter(entry.target, text, 0);
    }
  });
  });

  const targetElement = document.querySelector('#target-element');
  observer.observe(targetElement);
  
  };

  
  function typeWriter(p, text, i) {
    if (i < text.length) {
      p.innerHTML += text.charAt(i);
      i++;
      setTimeout(function() { typeWriter(p, text, i); }, 50);
    }
  };
