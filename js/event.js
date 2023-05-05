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

let card_buttons = document.querySelectorAll('.card .show_e');

card_buttons.forEach(function(elem){
    elem.addEventListener('click',()=>{
    let id_event = elem.getAttribute('event');
    $.ajax({
        url: '../php_request/show_event.php?id=' + id_event,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
          if(result['error']){
            window.location.replace("event.php");
            return;
          }

          const overlay = document.createElement('div');
          const form = document.createElement('form');
          
          form.setAttribute('method','post');
          form.setAttribute('action','../php_request/join_event.php');

          let backgroung_type;
          let color_type;

          if(result['event_type']=='course'){
            backgroung_type='red';
            color_type='white';
          }else if(result['event_type']=='confrence'){
            backgroung_type='#FFEB3B';
            color_type='black';
          }else if(result['event_type']=='contest'){
            backgroung_type='blue';
            color_type='white';
          }

          form.innerHTML= `
          
          <div class="mb-3"style='
            background-color: ${backgroung_type};
            color: ${color_type};
            width: 120px;
            padding: 5px;
            border-radius: 9px;
            display: flex;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 600;
          '>${result['event_type']}</div>
          <div class="mb-3 title_c">${result['event_name']}</div> 

          <div class="mb-3" style = '
            display: flex;
            justify-content: space-around;
            background-color: black;
            color: white;
            border-radius: 5px;
          '>
          <div>
          <i class="fa-solid fa-user"></i>          
          <span class='num_pract'>${result['num_pract']}</span>
          </div>

          <div>
          <i class="fa-solid fa-clock"></i>         
          <span>${result['time_create']}</span>
          </div>

          </div>
          
          <div class="mb-3 desc text-center">
              <div class='t'>Submit Duration</div>
              <div><i class="fa-regular fa-calendar-check"></i> ${result["from_date"]}</div>
              <div><i class="fa-regular fa-calendar-xmark"></i> ${result["to_date"]}</div>
          </div>

          <div class="mb-3 desc text-center">
              <div class='t'>Start Duration</div>
              <div><i class="fa-regular fa-calendar-check"></i> ${result["start_date"]}</div>
              <div><i class="fa-regular fa-calendar-xmark"></i> ${result["end_date"]}</div>
          </div>
  
          <div class="mb-3 desc text-center">
              <div class='t'>Number of lectures</div>
              <div>${result["num_lecture"]} Lectures</div>
          </div>
          
          <div class="mb-3 desc text-center">
              <div class='t'>Description</div>
              <div>${result['description'].replace(/\n/g, "<br>")}</div>
          </div>`;

          if(result['content']){
            form.innerHTML+= `
            <div class="mb-3 desc text-center">
                <div class='t'>Content</div>
                <div>
                  ${result['content'].replace(/\n/g, "<br>")}
                </div>
            </div>`;
          }
          if(result['qualification']){
            form.innerHTML+= `
            <div class="mb-3 desc text-center">
                <div class='t'>Qualification</div>
                <div>
                    ${result['qualification'].replace(/\n/g, "<br>")}
                </div>
            </div>
            `;
          }

          if(result['qualification']){
            form.innerHTML+= `
            <div class="mb-3 desc text-center">
                <div class='t'>Qualification</div>
                <div>
                    ${result['experience'].replace(/\n/g, "<br>")}
                </div>
            </div>
            `;
          }

          to_date = new Date(result['to_date']);
          now_date = new Date();
          if(to_date < now_date){
            form.innerHTML += `
            <div style = '
            height: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f443363d;
            border-radius: 5px;
            font-size: 1.3rem;
            font-weight: 600;
            color: #f44336ed;
            ' >End</div>
            `;
          }else{
            if(result['status']==0){
            form.innerHTML += `
            <div class="text-center">
            <button type="submit" style='width: 20%;' class="btn btn-success mx-auto" name ='practice' value='1'>join</button>
            </div>
            `;
            }else if(result['status']>0){
              form.innerHTML += `
            <div class="text-center">
            <button type="submit" style='width: 20%;' class="btn btn-danger mx-auto" name ='practice' value='0'>Unjoin</button>
            </div>
              `;
            }
          }
          
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

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });    
    });
});