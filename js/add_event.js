document.addEventListener("DOMContentLoaded", function() {

    let b_l = document.querySelector(".login");
    let b_s = document.querySelector(".signup");
    
    if(b_l!=null){
    b_l.addEventListener('click',function() {
        const overlay = document.createElement('div');
        const form = document.createElement('form');
        
        form.setAttribute('method','post');
        form.setAttribute('action','../php_request/login.php');
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
        window.location.replace("signup.php");
    });
    }
    });

var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {    
        if (form.checkValidity() === false ) {
            form.classList.add('was-validated');
            event.preventDefault();
        }
        else{
            setTimeout(event.returnValue = true,1000);
        }
    }, false);
},false);

var image = document.getElementById("image");
var i_m=null;
image.addEventListener('input',function(){
    if(image.value =='other'){
        i_m = document.createElement('div');
        i_m.classList.add('col-md-6','mb-2');
        i_m.innerHTML=`
        <label for="file" class="form-label">Upload image <sub style='color:red;'>*</sub></label>
        <input class="form-control" type="file" id="file" required>
        `;
        var i_im = document.getElementsByClassName('i-image')[0];
        i_im.appendChild(i_m);  
    }
    else if(i_m!=null){
        i_m.remove();
        i_m=null;
    }
});