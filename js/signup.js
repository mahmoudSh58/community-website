let b_l = document.querySelector(".login");
let b_s = document.querySelector(".signup");
b_l.addEventListener('click',function() {
    const overlay = document.createElement('div');
    const form = document.createElement('form');
    
    form.setAttribute('method','post');
    form.setAttribute('action','../php_request/login.php');
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

  var forms = document.getElementsByClassName('needs-validation');
  // Loop over them and prevent submission
  var validation = Array.prototype.filter.call(forms, function(form) {
    form.classList.add('was-validated');
    form.addEventListener('submit', function(event) {    
        var password = document.getElementById("inputPassword1");
        var b = false;
        if(password.value.length < 6){
            b=true;
            password.classList.remove('is-valid');
            password.classList.add('is-invalid');
        }
        if (form.checkValidity() === false  || b) {
            event.preventDefault();
        }
        else{
            setTimeout(event.returnValue = true,1000);
        }
    }, false);
},false);


var password = document.getElementById("inputPassword1");
password.addEventListener('input',function(event){
    event.preventDefault();
    if(password.value.length < 6){
        password.classList.remove('is-valid');
        password.classList.add('is-invalid');
    }
    else{
        password.classList.remove('is-invalid');
        password.classList.add('is-valid');
    }
});

var college = document.getElementById("college");
var i_c=null;
college.addEventListener('input',function(){
    if(college.value =='other'){
        i_c = document.createElement('div');
        i_c.classList.add('col-md-6','mb-2');
        i_c.innerHTML=`
        <label for="other">Name of College</label>
        <input type="text" class="form-control" id="other" placeholder="College" name='college_name' required>
        <div class="invalid-feedback">
          Please provide a valid College.
        </div>
        <div class="valid-feedback">
            Looks good!
        </div>
        `;
        var i_co = document.getElementsByClassName('i-college')[0];
        i_co.appendChild(i_c);  
    }
    else if(i_c!=null){
        i_c.remove();
        i_c=null;
    }
});

window.onload =()=>{
    let birth = document.getElementById('birthday');
    const defaultYear = 2001;

    // Get the current year
    const currentYear = new Date().getFullYear();

    // Loop through the years and create an option element for each year
    for (let year = 1980; year <= currentYear; year++) {
    const option = document.createElement('option');
    option.text = year;
    option.value = year;
    if (year === defaultYear) {
        option.selected = true;
    }
    birth.add(option);
    }
};