window.onload=function(){let t=document.querySelector("#tool-bg"),n=document.querySelector("#tool-1"),o=document.querySelector("#tool-2"),r=document.querySelector("#tool-3");null!=t&&t.addEventListener("mousemove",function(t){var e=t.clientX-window.innerWidth/2,t=t.clientY-window.innerHeight/2;n.style.transform="translateX("+(5+e/150)+"%) translateY("+(1+t/150)+"%)",o.style.transform="translateX(-"+(5+e/160)+"%) translateY(-"+(1+t/160)+"%)",r.style.transform="translateX(-"+(5+e/150)+"%) translateY(-"+(1+t/150)+"%)"})};