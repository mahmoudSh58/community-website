
document.addEventListener("DOMContentLoaded", function() {

let b_l = document.querySelector(".login");
let b_s = document.querySelector(".signup");

if(b_l!=null){
  b_l.addEventListener('click',function() {
      const overlay = document.createElement('div');
      const form = document.createElement('form');
      
      form.setAttribute('method','post');
      form.setAttribute('action','php_request/login.php');
      form.innerHTML= `
      <div class="mb-3">
        <label for="Email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="Email" placeholder="Email" name='email' aria-describedby="emailHelp">
      </div> 
      <div class="mb-3">
        <label for="Password" class="form-label">Password</label>
        <input type="password" class="form-control" id="Password" name='password' placeholder="Password">
      </div>
      <div class="mb-3">
      <a href="" class="btn btn-link" style="
      padding: 2px;
      text-decoration: none;
      font-size: 0.8rem;
      ">Contact Us</a>
      </div>
      <button type="submit" class="btn btn-primary mx-auto">Login</button>
      `

      let b_x = document.createElement('div');
      b_x.innerHTML = `<i class="fa-solid fa-xmark"></i>`;
      b_x.classList.add("mb-3" ,"btn" ,"xmark");
      form.appendChild(b_x);

      form.classList.add('overform');

      overlay.classList.add('overlay');
      document.body.appendChild(overlay);
      document.body.style.overflow = 'hidden';
      
      overlay.onclick = function(){
          overlay.remove();
          form.remove();
          document.body.style.overflow = 'initial';
      }
      
      b_x.onclick = function () {
          overlay.click();
      };

      document.body.appendChild(form);
    });
}

if(b_s!=null){
  b_s.addEventListener('click',function (){
    window.location.replace("./page/signup.php");
  });
}

});