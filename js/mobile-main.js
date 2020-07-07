document.addEventListener("DOMContentLoaded", function (event) {
    let mobileBar = document.querySelector('.menu__bar-mobile')
    let mobileBarItems = document.querySelectorAll('.bar__mobile-item')
    let mobileMenu = document.querySelector('.site-navigation')

    mobileBar.onclick=function(){
        if(mobileBar.style.transform=='rotate(0deg)'||mobileBar.style.transform==''){
            mobileBar.style.transform='rotate(-90deg)'
            mobileMenu.style.top='0'
            mobileBarItems[1].style.width='0'
            mobileBarItems[0].style.transform='rotate(45deg)'
            mobileBarItems[2].style.transform='rotate(-45deg)'
        }
        else{
            mobileBar.style.transform='rotate(0deg)'
            mobileMenu.style.top='-100vh'
            mobileBarItems[1].style.width='100%'
            mobileBarItems[0].style.transform='rotate(0deg)'
            mobileBarItems[2].style.transform='rotate(0deg)'
        }
       
    }


}, false);