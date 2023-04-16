let b_l = document.querySelector(".login");
let b_s = document.querySelector(".signup");

b_l.onclick = function() {
    const overlay = document.createElement('div');
    const form = document.createElement('form');
    
    form.innerHTML= `
    <div class="mb-3">
      <label for="Email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="Email" placeholder="Email" aria-describedby="emailHelp">
    </div> 
    <div class="mb-3">
      <label for="Password" class="form-label">Password</label>
      <input type="password" class="form-control" id="Password" placeholder="Password">
    </div>
    <div class="mb-3">
    <a href="" class="btn btn-link" style="
    padding: 2px;
    text-decoration: none;
    font-size: 0.8rem;
    ">Contact Us</a>
    </div>
    <button type="submit" class="btn btn-primary mx-auto">Login</button>
    `;

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
  };


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
            //php code
            event.preventDefault();
            window.location.href = "../index.html"; 
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
        <input type="text" class="form-control" id="other" placeholder="College" required>
        <div class="invalid-feedback">
          Please provide a valid College.
        </div>
        <div class="valid-feedback">
            Looks good!
        </div>
        `;
        var i_co = document.getElementsByClassName('i-college')[0];
        console.log(i_co);
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