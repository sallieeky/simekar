<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
  <body>
    <h1>Hello, world!</h1>
    <p class="readmore" data-text="Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, natus. Reiciendis, modi labore ipsum ipsam blanditiis omnis totam cupiditate? Eius doloribus quis expedita quod ullam assumenda. Accusamus iure veritatis nemo a exercitationem optio tempore dolor officiis quae inventore accusantium provident sint magnam est, eos doloribus totam libero in odio. Laborum?">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, natus. Reiciendis, modi labore ipsum ipsam blanditiis omnis totam cupiditate? Eius doloribus quis expedita quod ullam assumenda. Accusamus iure veritatis nemo a exercitationem optio tempore dolor officiis quae inventore accusantium provident sint magnam est, eos doloribus totam libero in odio. Laborum?</p>
    <p class="readmore" data-text="Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, natus. Reiciendis, modi labore ipsum ipsam blanditiis omnis totam cupiditate? Eius doloribus quis expedita quod ullam assumenda. Accusamus iure veritatis nemo a exercitationem optio tempore dolor officiis quae inventore accusantium provident sint magnam est, eos doloribus totam libero in odio. Laborum?">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, natus. Reiciendis, modi labore ipsum ipsam blanditiis omnis totam cupiditate? Eius doloribus quis expedita quod ullam assumenda. Accusamus iure veritatis nemo a exercitationem optio tempore dolor officiis quae inventore accusantium provident sint magnam est, eos doloribus totam libero in odio. Laborum?</p>
    <p class="readmore" data-text="Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, natus. Reiciendis, modi labore ipsum ipsam blanditiis omnis totam cupiditate? Eius doloribus quis expedita quod ullam assumenda. Accusamus iure veritatis nemo a exercitationem optio tempore dolor officiis quae inventore accusantium provident sint magnam est, eos doloribus totam libero in odio. Laborum?">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, natus. Reiciendis, modi labore ipsum ipsam blanditiis omnis totam cupiditate? Eius doloribus quis expedita quod ullam assumenda. Accusamus iure veritatis nemo a exercitationem optio tempore dolor officiis quae inventore accusantium provident sint magnam est, eos doloribus totam libero in odio. Laborum?</p>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            $('.readmore').each(function(){
                var text = $(this).text();
                if(text.length > 100){
                    $(this).text(text.substring(0,100));
                    $(this).append('<a href="#" class="read-more">Read more</a>');
                }
            });
            $(document).on('click', '.read-more', function(){
                $(this).parent().html($(this).parent().data('text') + "<a href='#' class='read-less'>Read less</a>");
            });
            $(document).on('click','.read-less',function(){
                var text = $(this).parent().data('text');
                $(this).parent().text(text.substring(0,100)).append('<a href="#" class="read-more">Read more</a>');
            });
        });
    </script>
  </body>
</html>