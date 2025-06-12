
(function ($) {

    $.fn.codexgraph = function (options) {

        // Establish our default settings
        var settings = $.extend({
            knobcolor: 'red',
            fillcolor: 'yellow',
            textcolor: 'green',
        }, options);

        return this.click(function () {

            var knobcolor = settings.knobcolor;
            var circlebg = settings.fillcolor;
            var color = settings.textcolor;
            var per = $(this).attr("data-pamt");


            var canvas = document.getElementById('skill_graph');
            var context = canvas.getContext('2d');
            var x = canvas.width / 2;
            var y = canvas.height / 2;
            var radius = 75;

            var endPercent = per;
            var curPerc = 0;
            var counterClockwise = false;
            var circ = Math.PI * 2;
            var quart = Math.PI / 2;

            context.lineWidth = 18;
            context.strokeStyle = knobcolor;
            context.shadowOffsetX = 0;
            context.shadowOffsetY = 0;



            function animate(current) {
                context.clearRect(0, 0, canvas.width, canvas.height);


                context.beginPath();
                context.arc(x, y, radius - 8, 0, 2 * Math.PI, false);
                context.fillStyle = circlebg;
                context.fill();
                context.closePath();


                context.beginPath();
                context.arc(x, y, radius, -(quart), ((circ) * current) - (quart), false);
                context.stroke();
                curPerc++;



                context.font = '40px "Jura"';
                context.textAlign = 'center';
                context.textBaseline = 'middle';
                context.fillStyle = color;
                context.fillText(curPerc + "%", x, y);



                if (curPerc < endPercent) {
                    requestAnimationFrame(function () {
                        animate((curPerc + 1) / 100)

                    });

                }
            }


            animate();

        });

    }

}(jQuery));


$("a").codexgraph({
    knobcolor: '#14b9d5',
    fillcolor: '#fff',
    textcolor: '#000',
  });



  $("a:first").trigger("click");
  $("a:first").css({
    'color': '#59d9c5',
    "background-color": '#1c1c1c;',

  });

  $("a").click(function () {
    $("a").css({
      'color': '#FFF',
      "background-color": '#1c1c1c;',

    });
    $(this).css({
      'color': '#59d9c5',
      "background-color": '#000;',

    });
  });

