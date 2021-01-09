<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Navigation</title>
    <style media="screen">
    *{

    }
    a{
      border:3px solid coral;
      padding:20px 40px;
      color:#555;
      text-decoration: none;
      position: absolute;
      top: 50%;
      left:50%;
    }
      a::before{
        content: "";
        background: coral;
        width: 100%;
        height: 0;
        display: block;
        transition: 0.3s height;
        position: absolute;
        bottom: 0%;
        left:0%;
        z-index:-1;
      }
      a:hover{
        color:#fff;
      }
      a:hover::before{
        height:100%;

      }
      @media only screen and (max-width: 500px){
        .toptitle h4, .toptitle h2{
          position: inherit;
          font-size:17px;
        }
      }
    </style>
  </head>
  <body>
    <section>
      <br><br><br><br><br><br><br>
      <a>Hover me </a>
    </section>
  </body>
</html>
