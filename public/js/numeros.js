flag=false;
$(document).ready(function () {
    anime({
        targets: '.svg path',
        strokeDashoffset: [anime.setDashoffset, 2],
        easing: 'linear',
        duration: 8000,
        loop: true
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    setInterval(function(){ ConsultarInicioSorteo() }, 1000);
    //ConsultarInicioSorteo();
});
function ConsultarInicioSorteo() {
    if(flag==false)
    {
        flag=true;
        $.ajax({
            type: 'GET',
            url: './ConsultarIniciadoSorteoJson',
            success: function (response) {
                console.log(response);
                if(response.respuesta==true)
                {
                    var clientes= response.clientes;
                    $(".fly-inn").html("");
                    var myArray = ['1','2','3','4','5','6','7','8','9','10'];
                    shuffle(myArray);
                    i=1;
                    while (i<=10) {
                        $.each(myArray, function( index, value ) {
                            if(i==10 && index==0)
                            {
                                $("#Opcion"+value).append( "<div><p style='font-size:20vh;line-height:1;'>Ganador<p/><p>"+response.qwerty+"</p></div>" );
                                //$("#Opcion"+value).append( "<div><p style='font-size:20vh;line-height:1;'>Ganador<p/><p>Juan Perez</p></div>" );
                            }
                            else
                            {
                                //$("#Opcion"+value).append( "<div>"+Math.floor((Math.random() * 1000000) + 1)+"</div>" );
                                indiceCliente=Math.floor(Math.random()*clientes.length);
                                nombre=firstWord = clientes[indiceCliente].nombre.replace(/ .*/,'');
                                $("#Opcion"+value).append( "<div>"+nombre+" "+clientes[indiceCliente].apellidoPaterno+"</div>" );
                                clientes.splice(indiceCliente, 1 );
                            }
                        });
                        myArray.shift();
                        i++;
                    }
                    $(".fly-inn").css('display','block');
                    $(".fly-inn").addClass("fly-in");
                }
                flag=false;
            },
        });
    }
    else
    {
        return false;
    }

}
function shuffle(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}


// const canvas = document.querySelector('canvas');
// const context = canvas.getContext('2d');
// const colorPalette = ['69D2E7', 'A7DBD8', 'E0E4CC', 'F38630', 'FA6900'];

// canvas.width = window.innerWidth;
// canvas.height = window.innerHeight;

// canvas.addEventListener('resize', function() {
//   canvas.width = window.innerWidth;
//   canvas.height = window.innerHeight;
// });

// class Firework {
//   constructor() {

//     class FireworkHead {
//       constructor() {
//         this.positionX =  null;
//         this.positionY = null;
//         this.width = 2;
//         this.height = 2;
//         this.opacity = 0;
//         this.velocityX = parseFloat(Math.cos(Math.random() * 10 * Math.PI).toFixed(4));
//         this.velocityY = parseFloat(Math.sin(Math.random() * 10 * Math.PI).toFixed(4));
//       }
//     }

//     this.body = {
//       positionX: canvas.width / 2,
//       positionY: Math.random() * (canvas.height * 1.1 - canvas.height) + canvas.height,
//       width: 2,
//       height: 2,
//       opacity: 1,
//       velocityX: parseFloat(Math.cos(Math.random() * 1 * Math.PI).toFixed(4)),
//       velocityY: 10,
//       decay: Math.random() * (canvas.height / 3 - canvas.height / 4) + canvas.height / 4,
//       color: colorPalette[Math.floor(Math.random() * colorPalette.length)]
//     };

//     this.tail = {
//       height: 40,
//       width: 20,
//     };

//     this.headReset = function() {
//       this.head = new Array(20).fill(0).map(el => new FireworkHead());
//     }

//     this.headReset();
//   }
// }

// let fireworks = new Array(20).fill(0).map(el => new Firework());

// const drawFirework = (firework) => {
//   if(firework.body.decay < 100 || firework.body.velocityY < 0.5) {
//     for (let i = 0; i < firework.head.length; i++) {
//       if(firework.head[i].positionX === null) {
//         firework.head[i].positionX = firework.body.positionX;
//       }
//       if(firework.head[i].positionY === null) {
//         firework.head[i].positionY = firework.body.positionY;
//       }
//       firework.head[i].positionX += firework.head[i].velocityX;
//       firework.head[i].positionY += firework.head[i].velocityY;

//       drawFireworkHead(firework, firework.head[i]);
//     }
//   } else {
//     drawFireworkBody(firework);
//   }
// };

// const drawFireworkBody = (firework) => {
//   context.beginPath();
//   context.fillStyle = 'white';
//   context.arc(firework.body.positionX, firework.body.positionY, firework.body.width, 0, 2 * Math.PI);
//   context.fill();
//   context.closePath();
// };

// const drawFireworkHead = (firework, fireworkHead) => {
//   context.save();
//   context.globalAlpha = firework.body.decay / 50;
//   context.beginPath();
//   context.fillStyle = `#${firework.body.color}`;
//   context.arc(fireworkHead.positionX, fireworkHead.positionY, fireworkHead.width, 0, 2 * Math.PI);
//   context.fill();
//   context.closePath();
//   context.restore();
// };

// const moveFirework = (firework) => {
//   firework.body.velocityY *= 0.99;
//   firework.body.positionY -= firework.body.velocityY;
//   firework.body.positionX += firework.body.velocityX;
//   firework.body.decay -= 1;
// }

// const renderStage = () => {
//   context.clearRect(0, 0, canvas.width, canvas.height);
//   for (let i = fireworks.length - 1; i >= 0; i--) {
//     if(fireworks[i].body.decay > 1) {
//       moveFirework(fireworks[i]);
//       drawFirework(fireworks[i]);
//     } else {
//       fireworks = fireworks.filter((firework, index) => index !== i);
//     }
//   }
//   requestAnimationFrame(renderStage);
// };

// renderStage();

// canvas.addEventListener('click', function(event) {
//   const newFireworks = new Array(10).fill(0).map(el => {
//     let newFirework = new Firework();
//     newFirework.body.positionX = event.clientX;
//     return newFirework;
//   });
//   fireworks = [...fireworks, ...newFireworks];
// })

/*******************************************************************

 ========= CONFETTI JAVASCRIPT  =========
 =========      BY TRELLO       =========

 As seen on https://trello.com/10million
 _______________________________________

 Copyright © Trello. All rights Reserved.
 _______________________________________

 XXX Use for Educational Purposes only XXX

 I will not be liable for any damages or legal actions for Using of this material.

 *******************************************************************/



var COLORS, Confetti, NUM_CONFETTI, PI_2, canvas, confetti, context, drawCircle, drawCircle2, drawCircle3, i, range, xpos;
NUM_CONFETTI = 40;
COLORS = [
    [235, 90, 70],
    [97, 189, 79],
    [242, 214, 0],
    [0, 121, 191],
    [195, 119, 224]
];
PI_2 = 2 * Math.PI;
canvas = document.getElementById("confeti");
context = canvas.getContext("2d");
window.w = 0;
window.h = 0;
window.resizeWindow = function() {
    window.w = canvas.width = window.innerWidth;
    return window.h = canvas.height = window.innerHeight
};
window.addEventListener("resize", resizeWindow, !1);
window.onload = function() {
    return setTimeout(resizeWindow, 0)
};
range = function(a, b) {
    return (b - a) * Math.random() + a
};
drawCircle = function(a, b, c, d) {
    context.beginPath();
    context.moveTo(a, b);
    context.bezierCurveTo(a - 17, b + 14, a + 13, b + 5, a - 5, b + 22);
    context.lineWidth = 2;
    context.strokeStyle = d;
    return context.stroke()
};
drawCircle2 = function(a, b, c, d) {
    context.beginPath();
    context.moveTo(a, b);
    context.lineTo(a + 6, b + 9);
    context.lineTo(a + 12, b);
    context.lineTo(a + 6, b - 9);
    context.closePath();
    context.fillStyle = d;
    return context.fill()
};
drawCircle3 = function(a, b, c, d) {
    context.beginPath();
    context.moveTo(a, b);
    context.lineTo(a + 5, b + 5);
    context.lineTo(a + 10, b);
    context.lineTo(a + 5, b - 5);
    context.closePath();
    context.fillStyle = d;
    return context.fill()
};
xpos = 0.9;
document.onmousemove = function(a) {
    return xpos = a.pageX / w
};
window.requestAnimationFrame = function() {
    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(a) {
        return window.setTimeout(a, 5)
    }
}();
Confetti = function() {
    function a() {
        this.style = COLORS[~~range(0, 5)];
        this.rgb = "rgba(" + this.style[0] + "," + this.style[1] + "," + this.style[2];
        this.r = ~~range(2, 6);
        this.r2 = 2 * this.r;
        this.replace()
    }
    a.prototype.replace = function() {
        this.opacity = 0;
        this.dop = 0.03 * range(1, 4);
        this.x = range(-this.r2, w - this.r2);
        this.y = range(-20, h - this.r2);
        this.xmax = w - this.r;
        this.ymax = h - this.r;
        this.vx = range(0, 2) + 8 * xpos - 5;
        return this.vy = 0.7 * this.r + range(-1, 1)
    };
    a.prototype.draw = function() {
        var a;
        this.x += this.vx;
        this.y += this.vy;
        this.opacity +=
            this.dop;
        1 < this.opacity && (this.opacity = 1, this.dop *= -1);
        (0 > this.opacity || this.y > this.ymax) && this.replace();
        if (!(0 < (a = this.x) && a < this.xmax)) this.x = (this.x + this.xmax) % this.xmax;
        drawCircle(~~this.x, ~~this.y, this.r, this.rgb + "," + this.opacity + ")");
        drawCircle3(0.5 * ~~this.x, ~~this.y, this.r, this.rgb + "," + this.opacity + ")");
        return drawCircle2(1.5 * ~~this.x, 1.5 * ~~this.y, this.r, this.rgb + "," + this.opacity + ")")
    };
    return a
}();
confetti = function() {
    var a, b, c;
    c = [];
    i = a = 1;
    for (b = NUM_CONFETTI; 1 <= b ? a <= b : a >= b; i = 1 <= b ? ++a : --a) c.push(new Confetti);
    return c
}();
window.step = function() {
    var a, b, c, d;
    requestAnimationFrame(step);
    context.clearRect(0, 0, w, h);
    d = [];
    b = 0;
    for (c = confetti.length; b < c; b++) a = confetti[b], d.push(a.draw());
    return d
};
step();
  