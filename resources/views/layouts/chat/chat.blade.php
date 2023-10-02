@extends('layouts.master')
@section('title')
    chat
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
<style>
    * {
    -webkit-box-sizing: border-box;
    -o-box-sizing: border-box;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-image: url(https://img.wallpapersafari.com/desktop/1600/900/30/86/q1EWxp.jpg);
  background-size: cover;
    margin: 0;
}

body::before {
    content: '';
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.6);
}



/* ----------------------------Start Components---------------------------- */
ul {
    list-style: none;
}
.p-chat-blue {
    background-color: #00b0ff;
    color: white;
    position: relative;
}
.p-chat-blue::before {
    content: '';
    border-width: 5px;
    border-style: solid;
    border-color: transparent #00b0ff transparent transparent;
    position: absolute;
    top: 50%;
    left: -10px;
    transform: translateY(-50%);
}
.p-chat-grey {
    background-color: #eceff1;
    align-self: end;
    position: relative;
}
.p-chat-grey::before {
    content: '';
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent transparent #eceff1;
    position: absolute;
    top: 50%;
    right: -10px;
    transform: translateY(-50%);
}
/* ----------------------------End Components---------------------------- */


.container {
    margin: 50px auto;
    width: 600px;
    height: 500px;
    background-color: white;
    border: 1px solid #e7e7e7;
    position: relative;
    display: grid;
    grid-template-columns: 250px auto;
}
.container .contacts {
    border-right: 1px solid #e7e7e7;
}
.container .head {
    padding: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.container .head .search {
    background-color: #eceff1;
    border: 1px solid #e7e7e7;
    font-size: 12px;
    border-radius: 20px;
    padding: 12px;
    width: 80%;
}
.container .head .search:focus {
    outline: none;
}
.container .head i {
    background-color: #00b0ff;
    color: white;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    line-height: 35px;
    text-align: center;
    font-weight: lighter;
    font-size: 12px;
}
.container .acounts {
    padding: 0;
    margin: 0;
}
.container .acounts li {
    padding: 12px 25px;
    position: relative;
    display: flex;
}
.container .acounts li::before {
    content: '02:09 PM';
    font-size: 10px;
    color: #9f9f9f;
    position: absolute;
    top: 15px;
    right: 25px;
}
.container .acounts li::after {
    content: '';
    width: 200px;
    height: 1px;
    background-color: #e7e7e7;
    position: absolute;
    top: 0;
    left: 25px;
}
.container .acounts li.active {
    background-color: #00b0ff;
    color: white;
    font-weight: bold;
}
.container .acounts li.active::before {
    color: white;
}
.container .acounts li.active::after {
    display: none;
}
.container .acounts li.active p {
    color: white;
}
.container .acounts li .image {
    width: 30px;
    height: 30px;
    border-radius: 50%;
}
.container .acounts li img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
}
.container .acounts li .text {
    margin-left: 10px;
}
.container .acounts li h5 {
    font-size: 11px;
    margin: 3px 0 0;
}
.container .acounts li p {
    font-size: 10px;
    font-weight: normal;
    color: #9f9f9f;
    margin: 3px 0 0;
}
.container .acounts li.active p {
    color: white;
}

.container .chat {
    display: grid;
    grid-template-rows: 40px auto;
}
.container .receiver-bar {
    padding: 12px 25px;
    width: 100%;
    background-color: #eceff1;
    font-size: 12px;
    border: 1px solid #e7e7e7;
}
.container .receiver-bar span {
    font-weight: bold;
}
.container .chat-space {
    padding: 25px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}
.container .chat-space .time {
    margin-bottom: 20px;
    font-size: 11px;
    color: #9f9f9f;
    display: flex;
    justify-content: space-between;
    align-items: baseline;
}
.container .chat-space .time hr {
    display: inline-block;
    width: 25%;
    height: 1px;
    border: none;
    background-color: #e7e7e7;
}
.container .chat-space .chat-content {
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
}
.container .chat-space .chat-content > div {
    width: fit-content;
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
    font-size: 12px;
}
.container .chat-space .input-bar {
    position: relative;
}
.container .input-bar input {
    border: 1px solid #e7e7e7;
    width: 100%;
    padding: 8px 50px 8px 30px;
    font-size: 12px;
    background-color: #eceff1;
    border-radius: 5px;
    position: relative;
}
.container .input-bar input:focus {
    outline: none;
}
.container .input-bar i {
    position: absolute;
    font-size: 12px;
    color: #a1a2a2;
}
.container .input-bar .attach {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
}
.container .input-bar .emoji {
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
}
.container .input-bar .send {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
}
</style>
@endsection

{{-- @section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    chating</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection --}}


@section('content')
<div class="container">

    <div class="contacts">
        <div class="head">
            <input type="text" placeholder="Search" class="search">
            <i class="fas fa-edit"></i>
        </div>
        <ul class="acounts">
            @foreach ($users as $user)
            <li>
                <div  class="m-2">
                    <img  src="https://upload.wikimedia.org/wikipedia/commons/f/fe/ThomasBangalter028_%28Cropped%29.jpg"
                        alt="">
                </div>
                <div class="text">
                    <p>{{$user->name}} </p>

                </div>
            </li>
            @endforeach



        </ul>
    </div>
    <div class="chat ">
        <div class="receiver-bar">To: <span>{{}}</span></div>
        <div class="chat-space">
            <div class="time"><hr> Monday, 02:09 PM <hr></div>
            <div class="chat-content">
                <div class="p-chat-blue">Template1 & Template2 has done &#9989;</div>
                <div class="p-chat-grey">دا كلام عظيم وجميل ومفيش اي مشكلة</div>
                <div class="p-chat-grey">إنتهينا من التصميم الثالث
                    للتطبيق على HTML + CSS
                    باذن الله في خلال ايام نرفعه للقناة</div>
                <div class="p-chat-blue">Ah shit, Here we go again</div>
                <div class="p-chat-grey">مايد ويز لاف باي إلزيرو</div>
            </div>
            <div class="input-bar">
                <input type="text" class="type">
                <i class="fas fa-paperclip attach"></i>
                <i class="far fa-smile-beam emoji"></i>
                <i class="far fa-paper-plane send">
                    <a href=""></a>
                </i>
            </div>
        </div>
    </div>
</div>


@endsection
