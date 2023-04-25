let b_l = document.querySelector(".login");
let b_s = document.querySelector(".signup");

b_l.onclick = function() {
    const overlay = document.createElement('div');
    const form = document.createElement('form');
    
    form.setAttribute('method','get')
    form.innerHTML= `
    <div class="mb-3">
      <label for="Email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="Email" placeholder="Email" required>
    </div> 
    <div class="mb-3">
      <label for="Password" class="form-label">Password</label>
      <input type="password" class="form-control" id="Password" placeholder="Password" required>
    </div>
    <div class="mb-3">
    <a href="" class="btn btn-link" style="
    padding: 2px;
    text-decoration: none;
    font-size: 0.8rem;
    ">Contact Us</a>
    </div>
    <button type="submit" class="btn btn-primary mx-auto">Practice</button>
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
  
  b_s.onclick = function (){
    window.location.replace("signup.html");
  };

let card_buttons = document.querySelectorAll('.card button');

card_buttons.forEach(function(elem){
    elem.addEventListener('click',()=>{
        const overlay = document.createElement('div');
        const form = document.createElement('form');
        
        form.setAttribute('method','get')
        form.innerHTML= `
        <div class="mb-3 title_c">Level 0</div> 
        
        <div class="mb-3 desc text-center">
            <div class='t'>submit Duration</div>
            <div>From : 1/4/2023</div>
            <div>To : 1/7/2023</div>
            <div>Start : 15/7/2023</div>
        </div>

        <div class="mb-3 desc text-center">
            <div class='t'>Description</div>
            <div>Programming principles and concepts in computer science will be explained to beginners.</div>
        </div>
        <div class="mb-3 desc text-center">
            <div class='t' >Duration</div>
            <div>1 month -> 8 lecture</div>
        </div>

        <div class="mb-3 desc text-center">
            <div class='t'>Content</div>
            <div>
                <p>binary system</p>
                <p>basic of computer architecture</p>
                <p>how compile code?</p>
                <p>what is IDE and judge?</p>
            </div>
        </div>

        <div class="mb-3 desc text-center">
            <div class='t'>Qualification</div>
            <div>
                Don't need
            </div>
        </div>
        <button type="submit" class="btn btn-primary mx-auto">Practice</button>
        `;
        
        let b_x = document.createElement('div');
        b_x.innerHTML = `<i class="fa-solid fa-xmark"></i>`;
        b_x.classList.add("mb-3" ,"btn" ,"xmark");
        form.appendChild(b_x);
    
        form.classList.add('overform_card');
    
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
});