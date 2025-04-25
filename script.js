const form = document.getElementById('signupForm');
const msgDiv = document.querySelector('.message'); // safer
const name = document.querySelector('#name');
const username=document.querySelector('#username');
const email = document.querySelector('#email');
const pass =document.querySelector('#pass');
//remark
const name_remark = document.querySelector('#name_remark');
const username_remark = document.querySelector('#username_remark');

username.addEventListener('keydown',()=>{
    username_remark.style.display='none';
});
form.addEventListener('submit', async function (e) {
    if(name.value === ''){
        name_remark.style.display='block';
        name_remark.innerHTML='Please Enter Full Name';
    }else{
     e.preventDefault();
    }
  const formData = new FormData(form);

  const response = await fetch('signup.php', {
    method: 'POST',
    body: formData
  });

  const result = await response.text();

  if (result.trim() === '1') {
    msgDiv.style.display = "block";
    msgDiv.innerHTML = `Registration is done Successfully!`;
    
    // Auto hide message
    setTimeout(() => {
      msgDiv.style.display = "none";
    }, 3000);
  }else if(result.trim() === 'username_error'){
    username.classList.add('input-remark');
    username_remark.style.display='block';
    username_remark.innerHTML='Username already existed';
  }
  else {
    msgDiv.style.display = "block";
    msgDiv.classList.add('js-msg');
    msgDiv.innerHTML = `${result}`;

    // Auto hide error message too
    setTimeout(() => {
      msgDiv.style.display = "none";
    }, 3000);
  }

  form.reset();
});
