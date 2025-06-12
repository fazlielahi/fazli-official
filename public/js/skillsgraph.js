
(function ($) {

  $.fn.codexgraph = function (options) {

    // Establish our default settings
    var settings = $.extend({
      knobcolor: 'red',
      fillcolor: 'red',
      textcolor: 'red',
    }, options);

    return this.click(function () {

      var knobcolor = settings.knobcolor;
      var circlebg = settings.fillcolor;
      var color = settings.textcolor;
      var per = $(this).attr("data-pamt");


      var canvas = document.getElementById('skills_graph');
      var context = canvas.getContext('2d');
      var x = canvas.width / 2;
      var y = canvas.height / 2;
      var radius = 75;

      var endPercent = per;
      var curPerc = 0;
      var counterClockwise = false;
      var circ = Math.PI * 2;
      var quart = Math.PI / 2;

      context.lineWidth = 15;
      context.strokeStyle = knobcolor;
      context.shadowOffsetX = 0;
      context.shadowOffsetY = 0;



      function animate(current) {
        context.clearRect(0, 0, canvas.width, canvas.height);


        context.beginPath();
        context.arc(x, y, radius - -9, 0, 2 * Math.PI, false);
        context.fillStyle = circlebg;
        context.fill();
        context.closePath();


        context.beginPath();
        context.arc(x, y, radius, -(quart), ((circ) * current) - (quart), false);
        context.stroke();
        curPerc++;



        context.font = '30px "comic sans ms"';
        context.textAlign = 'center';
        context.textBaseline = 'top';
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


$(".skill").codexgraph({
  knobcolor: '#14cc55',
  fillcolor: '#00203fff',
  textcolor: '#adefd1ff',
});



$(".skill:first").trigger("click");
$(".skill:first").css({
  'color': '#14cc55',
  "background-color": '#1c1c1c;',

});

$(".skill").click(function () {
  $(".skill").css({
    'color': '#FFF',
    "background-color": '#1c1c1c;',
  });
  $(this).css({
    'color': '#14cc55',
    "background-color": '#000;',
  });
});

//to show skills title with graph

function skills(title) {

  if (title == "html") {
    skill_title.innerText = "HTML5";
  }
  else if(title == "css")
  {
    skill_title.innerText = "CSS3";
  }
  else if(title == "js")
  {
    skill_title.innerText = "JavaScript";
  }
  else if(title == "bs")
  {
    skill_title.innerText = "Bootstrap";
  }
  else if(title == "jq")
  {
    skill_title.innerText = "JQuery";
  }
  else if(title == "jq ui")
  {
    skill_title.innerText = "JQuery UI";
  }
  else if(title == "jq script")
  {
    skill_title.innerText = "JQuery Script";
  }
  else if(title == "php")
  {
    skill_title.innerText = "PHP - Hypertext Preprocessor";
  }
  else if(title == "mysql")
  {
    skill_title.innerText = "MYSQL";
  }
  else if(title == "oop")
  {
    skill_title.innerText = "Object oriented programming";
  }
  else if(title == "lvl")
  {
    skill_title.innerText = "Laravel";
  }
  else if(title == "wd")
  {
    skill_title.innerText = "WordPress";
  }
  else if(title == "api")
  {
    skill_title.innerText = "APIs";
  }
  else if(title == "ajax")
  {
    skill_title.innerText = "Ajax";
  }
  else if(title == "json")
  {
    skill_title.innerText = "JSON";
  }
  else if(title == "word")
  {
    skill_title.innerText = "Microsoft Word";
  }
  else if(title == "excel")
  {
    skill_title.innerText = "Microsoft Excel";
  }
  else if(title == "pp")
  {
    skill_title.innerText = "Microsoft PowerPoint";
  }else
  {
    skill_title.innerText = "Click on a skill to see its graph";
  }
}

