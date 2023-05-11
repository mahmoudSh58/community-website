document.addEventListener("DOMContentLoaded", function() {

    let b_l = document.querySelector(".login");
    let b_s = document.querySelector(".signup");
    
    if(b_l!=null){
      b_l.addEventListener('click',function() {
        const overlay = document.createElement('div');
        const form = document.createElement('form');
        
        form.setAttribute('method','post');
        form.setAttribute('action','php_request/login.php');
        form.setAttribute('class','text-center');
        form.setAttribute('style','border-radius: 10px;');
        form.innerHTML= `
        <div style='
        padding: 47px;
      font-size: 2.2rem;
      font-weight: 700;
      color: #795548;
        '>LOGIN</div>
        <div class="input-group mb-3" style='width:calc(100% - 50px)'>
          <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
          <input type="email" class="form-control text-center" id="email" placeholder="Email"  name='email'>
        </div> 
        <div class="mb-3">
          <div class="input-group">
          <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
          <input type="password" class="form-control rounded text-center" placeholder="Password" id="inputPassword1" name="password" minlength="6" required>
          <div class="input-group-prepend ms-1">
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                  <i class="fa fa-eye-slash" aria-hidden="true" id="eye_icon"></i>
                </button>
          </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary mx-auto w-50">Login</button>
        `
  
        let b_x = document.createElement('div');
        b_x.innerHTML = `<i class="fa-solid fa-xmark"></i>`;
        b_x.classList.add("mb-3" ,"btn" ,"xmark");
        form.appendChild(b_x);
  
        form.classList.add('overform');
  
        overlay.classList.add('overlay');
        overlay.classList.add('text-center');
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
        setTimeout(()=>{
          
          const togglePassword = document.querySelector('#togglePassword');
          const password_signup = document.querySelector('#inputPassword1');
          togglePassword.addEventListener('click', function (e) {
          // toggle the type attribute
          const type = password_signup.getAttribute('type') === 'password' ? 'text' : 'password';
          password_signup.setAttribute('type', type);
          // toggle the eye icon
          const icon = this.querySelector('#eye_icon');
          icon.classList.toggle('fa-eye');
          icon.classList.toggle('fa-eye-slash');
          });
  
          const email = document.getElementById('email');
          const password = document.getElementById('inputPassword1');
  
          email.addEventListener("focus", () => {
            email.placeholder = "";
          });
        
          email.addEventListener("blur", () => {
            email.placeholder = "Email";
          });
  
          password.addEventListener("focus", () => {
            password.placeholder = "";
          });
        
          password.addEventListener("blur", () => {
            password.placeholder = "Password";
          });
        },1000);
      });
    }
    
    if(b_s!=null){
      b_s.addEventListener('click',function (){
        window.location.replace("signup.php");
      });
    }
    });
