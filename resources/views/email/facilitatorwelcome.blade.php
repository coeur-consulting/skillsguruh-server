<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    /* Base */

body,
body *:not(html):not(style):not(br):not(tr):not(code) {
    box-sizing: border-box;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
        Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
        "Segoe UI Symbol";
    position: relative;
}

body {
    -webkit-text-size-adjust: none;
    background-color: #ffffff;
    color: #718096;
    height: 100%;
    line-height: 1.4;
    margin: 0;
    padding: 0;
    width: 100% !important;

}
    .body {
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
    -premailer-width: 100%;
    /* background-color: #badfe7; */
    border-bottom: 1px solid #badfe7;
    border-top: 1px solid #badfe7;
    margin: 0;
    padding: 0;
    width: 100%;
    text-align: left;
}
.inner-body {
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
    -premailer-width: 570px;
    background-color: #ffffff;
    border-color: #e8e5ef;
    border-radius: 2px;
    border-width: 1px;
    box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015);
    margin: 0 auto;
    padding: 0;
    width: 570px;
}
    .top_banner{
      min-height: 150px;
      width: 100%;
      background:#75b0b6;
      text-align: center;
      position: relative;
    }
    .button {
    -webkit-text-size-adjust: none;
    border-radius: 4px;
    color: #fff;
    display: inline-block;
    overflow: hidden;
    text-decoration: none;
    cursor: pointer;
}
.text-right{
  text-align: right;
}
.text-center{
  text-align: center;
}
td{
  width: 50%;
  padding: 15px;
}
.button-blue,
.button-primary {
    background-color: #388087;
    border-bottom: 8px solid #388087;
    border-left: 18px solid #388087;
    border-right: 18px solid #388087;
    border-top: 8px solid #388087;
}
.button-blue-outline,
.button-primary-outline {
    background-color: transparent;
    border: 1px solid #388087;
    padding: 5px 15px;
    color: #388087;
}
.text-green{
  color:#388087;
}
.mb-0{
  margin-bottom: 0
}
.mb-1{
  margin-bottom: .5rem
}

h1 {

    font-size: 18px;
    font-weight: bold;
    margin-top: 0;

}

h2 {

    font-size: 16px;
    font-weight: bold;
    margin-top: 0;

}

h3 {

    font-size: 14px;
    font-weight: bold;
    margin-top: 0;

}

p {

    font-size: 14px;
    line-height: 1.5em;
    margin-top: 0;
}

  .footer {
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
    -premailer-width: 570px;
    margin: 0 auto;
    padding: 0;
    text-align: center;
    width: 570px;
}

.footer span {
    color: #b0adc5;
    font-size: 12px;
}

.footer span a {
    color: #b0adc5;
    text-decoration: underline;
}
  </style>
</head>
<body class="body">

  <div class=" ">
<div class="top_banner">
<img src="{{asset('welcome.png')}}" width="300" height="auto" alt="Welcome">
</div>
<div class="text-left"  style="margin-bottom: 16px;padding-top:10px" >
  <h1>Greetings {{$name}}, </h1>
  <h2 class="text-green">Welcome to Nzukoor!, the Social Learning Place.</h2>
<p> We’ve created a home for you to share your experience or expertise. This can be in video, audio or text format; long, short, serious, funny, reported or opinionated. What matters is the quality of your content
</p>

<p>It is important to grow your community so remember to share share share, and invite your friends and foes. We will assist with growing your community as well, but the quality of your content is what will keep them engaged. </p>

<p>Count on us to hold your hands through it all by providing detailed user insight and technical support.
Shoot us a mail via the contact page or connect with our support team between 9:00am-5:00pm on +2349098800090
</p>

<p>See attached Onboarding document to get you started. The world needs a hero, just like you!</p>

<p>Sincerely, <br>
The Team @ Nzukoor</p>
<a href="http://nzukoor.com/login"><button class="button button-blue">Explore Nzukoor</button></a>

</div>

<footer class=" text-right text-green">
 <span><a href="http://nzukoor.com/contact" class="text-green">Contact</a></span> | <span><a class="text-green" href="http://nzukoor.com/about">About</a></span>
</footer>
  </div>
</body>
</html>