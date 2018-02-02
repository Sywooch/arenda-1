<?php
use app\components\helpers\CommonHelper;
$baseUrl = CommonHelper::data()->getParam('tld','arenda.ru');
/* @var $this \yii\web\View */
/* @var $context \yii2tech\html2pdf\Template */
$context = $this->context;

// specify particular PDF conversion for this template:
$context->pdfOptions = [
    'pageSize' => 'A4',
];
?>
<!DOCTYPE html>
<html lang="ru"><head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Отчёт о кредитной нагрузке</title>

    <!-- general styles -->
    <style>
        @page {
            size: A4;
            margin: 0 ;
        }

        @font-face{
            font-family: 'HelveticaNeueCyr';
            src: url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Roman.eot');
            src: url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Roman.woff') format('woff'),
            url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Roman.ttf') format('truetype'),
            url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Roman.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        @font-face{
            font-family: 'HelveticaNeueCyr';
            src: url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Bold.eot');
            src: url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Bold.woff') format('woff'),
            url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Bold.ttf') format('truetype'),
            url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Bold.svg') format('svg');
            font-weight: bold;
            font-style: normal;
        }
        @font-face{
            font-family: 'HelveticaNeueCyr';
            src: url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Light.eot');
            src: url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Light.woff') format('woff'),
            url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Light.ttf') format('truetype'),
            url('http://<?php echo $baseUrl; ?>/pdf-pages/fonts/HelveticaNeueCyr-Light.svg') format('svg');
            font-weight: 300;
            font-style: normal;
        }

        *,
        *:after,
        *:before{
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        html{
            font-size: 21.4px; /*32px;*/
            font-family: 'HelveticaNeueCyr', sans-serif;
            color: #3a434c;
        }
        body{
            width: 77.25rem;
            background: #ecf0f3;
            margin: 0;
            padding: 0;
        }

        p{
            margin: 0;
        }


        .wrapper{
            max-width: 100%;
            width: 66.25rem;
            padding: 0 0.625rem;
            margin: 0 auto;
            position: relative;
        }

        .padd-wrapper{
            padding-left: 3.4rem;
            padding-right: 3.4rem;
        }

        /* Header */

        .hdr{
            margin-bottom: 0;
        }
        .hdr__top{
            background-color: #fff;
        }
        .hdr__top .wrapper{
            height: 7.37500rem;
        }
        .hdr__top img{
            width: 12.65625rem;

            position: absolute;
            left: 20px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        .hdr__bot{
            background-color: #21272e;
            color: #ffc00f;
            font-size: 1.5625rem;
            font-weight: bold;
            letter-spacing: 0.05rem;
            padding: 1rem 0;
            line-height: 2rem;
            min-height: 4rem;
        }


        /* footer */
        .ftr{
            -webkit-page-inside-before: avoid;
            page-break-inside: avoid;
        }

        .ftr__inner{
            border-top: 1px solid #c5c5c5;
            font-size: 0;
            min-height: 8.8125rem;
            line-height: 4.8125rem;
            padding: 2rem 0;
        }
        .ftr__logo-col,
        .ftr__txt-col{
            display: inline-block;
            vertical-align: middle;
        }

        .ftr__logo-col{
            width: 13.8%;
        }
        .ftr__logo-col img{
            width: 7rem;
        }

        .ftr__txt-col{
            width: 86.2%;
            font-size: 0.653125rem;
            line-height: normal;
            color: #6a7576;
        }

        /* .top-info */

        .top-info{
            padding: 2.8rem 0 0;
            margin-bottom: 2.2rem;
        }
        .top-info__cols{
            margin-left: -0.5rem;
            margin-right: -0.5rem;
            font-size: 0;
        }
        .top-info__col{
            display: inline-block;
            vertical-align: top;
            padding: 0 0.5rem;
            margin-bottom: 1rem;
            font-size: 1.05rem;
        }
        .top-info__col-inner{
            text-align: left;
            display: inline-block;
            vertical-align: top;
        }
        .top-info__col h4{
            margin: 0 0 0.4rem;
        }

        .top-info__col--lg{width:47%}
        .top-info__col--md{width:29%}
        .top-info__col--sm{width:22%}
        .top-info__col--ta-right{
            text-align: right;
        }


        /* .panel */

        .panel{
            background-color: #fff;
            color: #3a434c;
            padding-top: 2.5rem;
            padding-bottom: 1.5rem;
            margin-top: 1.7rem;
            margin-bottom: 1.7rem;
            font-size: 0.92rem;
            -webkit-page-inside-before: avoid;
            page-break-inside: avoid;
        }

        .panel > p{
            margin-bottom: 0.7rem;
        }

        .panel-title{
            font-weight: 300;
            font-size: 1.5625rem;
            margin: 0 0 2.4rem;
        }

        .panel__cols{
            margin-left: -0.7rem;
            margin-right: -0.7rem;
            font-size: 0;
        }

        .panel__col{
            display: inline-block;
            vertical-align: top;
            padding-left: 0.7rem;
            padding-right: 0.7rem;
            font-size: 1rem;
        }

        .panel__col--25{width: 25%;}
        .panel__col--33{width: 32%;}
        .panel__col--50{width:50%;}

        /* for rating */
        .panel__col--29{width:29%;}
        .panel__col--71{width:71%;}
        /* Note */

        .note-wr{
            padding-top: 1.15rem;
            padding-bottom: 1.7rem;
            -webkit-page-inside-before: avoid;
            page-break-inside: avoid;
        }

        .note{
            font-size: 0.90625rem;
            position: relative;
            margin-bottom: 1rem;
        }

        .note:after{
            content: '';
            position: absolute;
            top: 0.3rem;
            left: 0;
            height: 1.87500rem;
            width: 1.3125rem;
            background: url('http://<?php echo $baseUrl; ?>/pdf-pages/pdf-img/lamp.svg') no-repeat center;
        }

        .note__txt{
            min-height: 1.87500rem;
            padding-left: 2.62500rem;
            line-height: 1.4;
        }
        .note p + p{
            margin-top: 0.5rem;
        }
    </style>
    <style>
        /* ===================== */
        /* Panel content */
        /* ======================== */

        .progress{
            margin: 2.4rem 0;
            padding-right: 4.53125rem;
        }
        .progress__line,
        .progress__progress{
            height: 1.1875rem;
            border-radius: 0.59375rem;
        }
        .progress__line{
            position: relative;
            background: #e5ebf0;
        }
        .progress__progress{
            position: absolute;
            left: 0;
            top: 0;
            background-color: #87c832;
        }
        .progress__status-gr{
            position: absolute;
            left: 100%;
            top: 50%;
            width: 2.5625rem;
            height: 2.34375rem;
            margin-top: -1.171875rem;
            margin-left: -1.2813rem;
        }
        .progress__status-visual{
            display: block;
            background-color: red;
            width: 2.5625rem;
            height: 2.34375rem;
            background: url("http://<?php echo $baseUrl; ?>/pdf-pages/pdf-img/progress-star-green.png") no-repeat center;
            background-size: contain;
        }
        .progress__status-numb{
            position: absolute;
            left: 100%;
            margin-left: 0.3rem;
            top: 50%;
            margin-top: -0.5rem;
            font-size: 1rem;
            font-weight: bold;
            letter-spacing: 1px;
            line-height: 1;
            color: #87c832;
        }

        /* .progress--red */
        .progress--red .progress__status-numb{color: #d42d2d;}
        .progress--red .progress__progress{background-color: #d42d2d;}

        /* .progress--orn */
        .progress--orange .progress__status-numb{color: #ed8811;}
        .progress--orange .progress__progress{background-color: #ed8811;}

        /* .circle-icon  */
        .circle-icon {
            display: inline-block;
            vertical-align: middle;
            position: relative;
            z-index: 1;
        }
        .circle-icon:after{
            content: '';
            width: 5.1875rem;
            height: 5.1875rem;
            margin: -2.59375rem 0 0 -2.59375rem;
            border-radius: 50%;
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;

            background: #d9f6c4;
        }
        .circle-icon svg{
            position: relative;
            z-index: 2;
            fill: #6a972e;
        }
        .circle-icon--passport{width: 5.25rem;}
        .circle-icon--phone{width: 5.5rem;}
        .circle-icon--town{width: 7.2rem;}

        .circle-icon--paper{width: 5.59375rem;}
        .circle-icon--judge{width: 5.96875rem;}

        .circle-icon--policeman{width: 4.7rem;}
        .circle-icon--drugs{width: 6.2rem;}
        .circle-icon--lupa{width: 5.1rem;}

        .circle-icon--map{width: 4.5rem;}
        .circle-icon--money{width: 4.7rem;}
        /* .item-check */

        .item-check{

        }
        .panel__col .item-check{margin: 0.8rem 0 2.1rem;}
        .item-check__ico-wr{
            height: 5.9375rem;
            line-height: 5.9375rem;
            margin-bottom: 1.2rem;
            position: relative;
        }

        .item-check__ico-wr .circle-icon{
            max-width: 100%;
            max-height: 5.9375rem;
            position: absolute;
            left: 0;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }
        .item-check__txt-wr{
            font-size: 0.78125rem;
            line-height: normal;
            white-space: normal;
        }
        .item-check__txt-wr > *:last-child{margin-bottom: 0;}
        .item-check__title{
            font-weight: bold;
            margin-bottom: 0.37rem;
        }


        .item-check--valid .item-check__status{color:#6a972e}
        .item-check--danger .item-check__status{color:#ed8811}
        .item-check--invalid .item-check__status{color:#d42d2d}
        .item-check--invalid .circle-icon svg{fill:#d42d2d}
        .item-check--invalid .circle-icon:after{background-color: #ffd8d8}



        .item-check--inline{
            white-space: nowrap;
        }
        .panel__col .item-check--inline{margin: 1.2rem 0 2.9rem;}
        .item-check--inline .item-check__ico-wr,
        .item-check--inline .item-check__txt-wr{
            display: inline-block;
            vertical-align: middle;
        }
        .item-check--inline .item-check__ico-wr{
            width: 8rem;
            margin-right: -8rem;
            margin-bottom: 0rem;
            text-align: center;

            height: auto;
            line-height: normal;
        }
        .item-check--inline .item-check__ico-wr .circle-icon{
            position: relative;
            left: auto;
            top: auto;
            transform: translateY(0);
            max-height: none;
        }
        .item-check--inline .item-check__txt-wr{
            padding-left: 8.2rem;
            padding-top: 0.7rem;
        }


        /* .state-check */

        .state-check{
            display: table;

            min-width: 7.8125rem;
            text-align: center;
        }

        .state-check__ico-wr{
            margin: 0 auto 1.3rem;
            line-height: 7.8125rem;
            min-height: 7.8125rem;
            position: relative;
        }

        .state-check__ico-wr img{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate3d(-50%,-50%,0);
        }
        .state-check__txt{
            font-size: 0.90625rem;
            line-height: 1.3rem;
        }

        /* .circle-progress */

        .circle-progress{
            position: relative;
            z-index: 1;
            display: inline-block;
            vertical-align: middle;
            width: 7.8125rem;
            height: 7.8125rem;
        }
        .circle-progress__txt{
            position: absolute;
            top: 50%;
            left: 1rem;
            right: 1rem;
            line-height: 1rem;
            margin-top: -0.5rem;
            font-size: 2.25rem;
            font-weight: bold;
            color: #d2d2d2;
            text-align: center;
        }

        .circle-progress__path{
            fill: transparent;
            width: 100%;
            stroke-width: 0.24rem;
            stroke: #e5ebf0;
        }
        .circle-progress__progress{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;

            stroke-width: 0.24rem;
            stroke-dasharray: 4.6875rem;
            stroke-dashoffset: -4.6875rem;
            fill: transparent;
            stroke: transparent;
            stroke-linecap: round;
        }



        .circle-progress--10perc .circle-progress__progress{
            stroke-dashoffset: -4.21875rem;
        }
        .circle-progress--25perc .circle-progress__progress{
            stroke-dashoffset: -3.515625rem;
        }
        .circle-progress--50perc .circle-progress__progress{
            stroke-dashoffset: -2.34375rem;
        }
        .circle-progress--75perc .circle-progress__progress{
            stroke-dashoffset: -1.171875rem;
        }
        .circle-progress--33perc .circle-progress__progress{
            stroke-dashoffset: -3.12500rem;
        }
        .circle-progress--66perc .circle-progress__progress{
            stroke-dashoffset: -1.5625rem;
        }
        .circle-progress--90perc .circle-progress__progress{
            stroke-dashoffset: -0.46875rem;
        }
        .circle-progress--100perc .circle-progress__progress{
            stroke-dashoffset: 0;
        }


        .circle-progress--green .circle-progress__progress{stroke: #87c832;}
        .circle-progress--green .circle-progress__txt{color: #87c832;}

        .circle-progress--green-l .circle-progress__progress{stroke: #9fd35b;}
        .circle-progress--green-l .circle-progress__txt{color: #9fd35b;}

        .circle-progress--orange  .circle-progress__progress{stroke: #ed8811;}
        .circle-progress--orange  .circle-progress__txt{color: #ed8811;}

        .circle-progress--red  .circle-progress__progress{stroke: #d42d2d;}
        .circle-progress--red  .circle-progress__txt{color: #d42d2d;}

        /* Rating blocks */

        .credit-rating{
            margin: 2.5rem 0 2rem;
        }

        .credit-rating__heading-content{
            margin-bottom: 2.6rem;
            min-height: 4.5rem;
        }
        .credit-rating__desc{
            font-size: 0.91rem;
            line-height: 1.2;
        }
        .credit-rating__status-color{}

        .credit-rating__numb{
            font-weight: bold;
            line-height: 4.5rem;
            font-size: 6.25rem;
            letter-spacing: 0.15rem;
        }

        .credit-rating--valid .credit-rating__status-color,
        .credit-rating--valid .credit-rating__numb{color: #6ba124;}

        .credit-rating--invalid .credit-rating__status-color,
        .credit-rating--invalid .credit-rating__numb{color: #d42d2d;}

        .rating-chart{
            position: relative;
            width: 100%;
            height: 4.5rem;
            border-bottom: 0.1rem solid  #000;
            display: table;
        }

        .rating-chart__column{
            display: table-cell;
            position: relative;
            /*position: absolute;
            width: 9.09090909%;
            left: 0;*/
        }
        .rating-chart__column-filled-part{
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .rating-chart__column-filled-part-bg{
            position: absolute;
            bottom: 0;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1;
        }
        .rating-chart__column:nth-last-child(2) .rating-chart__column-filled-part-bg{
            opacity: 0.9;
        }
        .rating-chart__column:nth-last-child(3) .rating-chart__column-filled-part-bg{
            opacity: 0.8;
        }
        .rating-chart__column:nth-last-child(4) .rating-chart__column-filled-part-bg{
            opacity: 0.7;
        }
        .rating-chart__column:nth-last-child(5) .rating-chart__column-filled-part-bg{
            opacity: 0.6;
        }
        .rating-chart__column:nth-last-child(6) .rating-chart__column-filled-part-bg{
            opacity: 0.5;
        }
        .rating-chart__column:nth-last-child(7) .rating-chart__column-filled-part-bg{
            opacity: 0.44;
        }
        .rating-chart__column:nth-last-child(8) .rating-chart__column-filled-part-bg{
            opacity: 0.37;
        }
        .rating-chart__column:nth-last-child(9) .rating-chart__column-filled-part-bg{
            opacity: 0.3;
        }
        .rating-chart__column:nth-last-child(10) .rating-chart__column-filled-part-bg{
            opacity: 0.21;
        }
        .rating-chart__column:nth-last-child(11) .rating-chart__column-filled-part-bg{
            opacity: 0.14;
        }

        .rating-chart__column-name{
            position: absolute;
            left: 0;
            right: 0;
            top: 100%;
            text-align: center;
            padding: 0.7rem 0.2rem;
            color: #828c96;
            font-size: 0.375rem;
        }

        .rating-chart__pointer{
            position: absolute;
            top: 0;
            left: 50%;
            z-index: 2;
            width: 1.1875rem;
            height: 1.5rem;
            margin: -0.75rem 0 0 -0.59375rem;

            background-position: center;
            background-size: contain;
            background-repeat: no-repeat;
            background-image: url('http://<?php echo $baseUrl; ?>/pdf-pages/pdf-img/rating-pointer-good.png');
        }


        .rating-chart--positive{border-bottom-color: #87c832;}
        .rating-chart--positive .rating-chart__column-filled-part-bg{background: #87c832}
        .rating-chart--positive .rating-chart__pointer{background-image: url('http://<?php echo $baseUrl; ?>/pdf-pages/pdf-img/rating-pointer-good.png');}

        .rating-chart--negative{border-bottom-color: #d42d2d;}
        .rating-chart--negative .rating-chart__column-filled-part-bg{background: #d42d2d}
        .rating-chart--negative .rating-chart__pointer{background-image: url('http://<?php echo $baseUrl; ?>/pdf-pages/pdf-img/rating-pointer-bad.png');}
    </style>
    <style>
        /* helper classes */

        .h-c-red{color:#d42d2d;}
        .h-c-orn{color:#ed8811;}
        .h-c-green{color:#6a972e;}
        .h-c-green-l{color:#d9f6c4;}

        .h-bg-red{background-color:#d42d2d;}
        .h-bg-orn{background-color:#ed8811;}
        .h-bg-green{background-color:#6a972e;}
        .h-bg-green-l{background-color:#d9f6c4;}
    </style>
</head>
<body>

<div style="display:none;">
    <svg xmlns="http://www.w3.org/2000/svg">
        <symbol id="prog-circle" viewBox="0 0 57.8391 57.839">
            <path d="M28.917,5.0895c-13.1412,0-23.8324,10.6902-23.8324,23.8301S15.7758,52.7495,28.917,52.7495
	s23.8324-10.6899,23.8324-23.8299S42.0582,5.0895,28.917,5.0895z"></path>
        </symbol>


        <symbol id="papers" viewBox="0 0 16.3111 15.5119">
            <path d="M0.8331,13.0467c0.5667-0.0283,6.3471-0.0283,6.4887,0.0283c0.0567,0.17,0,0.3967,0.1983,0.9067
		c0.0567,0.1417,0.085,0.2267,0.17,0.3684c0.085,0.1133,0.1983,0.1983,0.2267,0.3117c-0.3967,0.0567-3.6552,0.0283-4.3636,0.0283
		c-0.68,0-1.3884,0.085-1.9268-0.2267C1.2298,14.2368,0.8047,13.7268,0.8331,13.0467z M4.63,9.1082h3.3435
		c0.1983,0,0.3967,0.1983,0.3967,0.3967v0.0283c0,0.2267-0.1983,0.3967-0.3967,0.3967H4.63c-0.2267,0-0.3967-0.17-0.3967-0.3967
		V9.5048C4.2333,9.3065,4.4033,9.1082,4.63,9.1082z M4.63,7.5497h4.5903c0.2267,0,0.3967,0.17,0.3967,0.3684v0.0283
		c0,0.2267-0.17,0.3967-0.3967,0.3967H4.63c-0.2267,0-0.3967-0.17-0.3967-0.3967V7.9181C4.2333,7.7197,4.4033,7.5497,4.63,7.5497z
		 M4.63,4.4329h2.1818c0.2267,0,0.3967,0.17,0.3967,0.3967v0.0283c0,0.1983-0.17,0.3684-0.3967,0.3684H4.63
		c-0.2267,0-0.3967-0.17-0.3967-0.3684V4.8296C4.2333,4.6029,4.4033,4.4329,4.63,4.4329z M4.63,5.963h4.5903
		c0.2267,0,0.3967,0.17,0.3967,0.3967V6.388c0,0.1983-0.17,0.3684-0.3967,0.3684H4.63c-0.2267,0-0.3967-0.17-0.3967-0.3684V6.3597
		C4.2333,6.133,4.4033,5.963,4.63,5.963z M15.454,3.2711h-3.2302c-0.0283-0.1983,0-0.7934,0-0.9917
		c0.0283-0.255,0.1417-0.5667,0.2834-0.7367c0.6517-0.9634,2.0401-0.9351,2.6918-0.0283c0.1133,0.1983,0.2267,0.4534,0.2834,0.7367
		C15.4823,2.4211,15.5106,3.1011,15.454,3.2711z M11.4021,2.5344v10.399c0,1.8984-2.2385,2.2951-3.0319,0.9351
		c-0.3117-0.5384-0.1983-0.9917-0.2267-1.6434c-1.5301,0-3.3719,0.0283-4.8736,0V2.7611c0-1.3601,0.595-1.9551,1.9551-1.9551h6.7437
		c-0.0283,0.17-0.255,0.3684-0.3967,0.765C11.4587,1.8827,11.4021,2.1661,11.4021,2.5344z M2.4482,12.225H0.0114
		c-0.0567,1.2467,0.085,1.9835,0.7367,2.6068c0.7934,0.7084,1.3884,0.68,2.6918,0.6517c0.68,0,6.2054,0.0567,6.6871,0
		c0.9067-0.1417,1.5868-0.7367,1.8984-1.4734c0.3117-0.7367,0.1983-2.2668,0.1983-3.1735c0-0.4817-0.0283-6.4604,0-6.7437
		c0.51-0.085,3.6836,0.0567,4.0803-0.0283c0-0.5384,0.0283-1.3317-0.0283-1.8418c-0.085-0.9351-0.7367-1.7851-1.6434-2.0968
		c-0.5384-0.17-1.1617-0.1133-1.7851-0.1133c-2.5218-0.0283-5.0153,0-7.5371,0c-1.1051,0-1.9268,0.1983-2.5502,1.2184
		C2.4765,1.7127,2.4482,2.1377,2.4482,2.7894v7.5371C2.4482,10.9499,2.4765,11.63,2.4482,12.225z"></path>
        </symbol>


        <symbol id="judge" viewBox="0 0 17.6971 17.7219">
            <path d="M10.0285,16.2373H7.705c-0.1983,0-0.51,0.34-0.595,0.4817h3.4852
		C10.5102,16.5773,10.1985,16.2373,10.0285,16.2373z M5.0982,14.2538H1.8113c0.17,0.2834,1.1901,0.51,1.6434,0.51
		S4.9282,14.5372,5.0982,14.2538z M3.4548,9.0118c-0.085,0.085-2.1251,4.1369-2.1535,4.2503h4.3069
		C5.5799,13.1487,3.5398,9.0968,3.4548,9.0118z M15.9222,12.2987h-3.2869c0.1417,0.2833,1.2184,0.4817,1.6434,0.4817
		S15.5822,12.6387,15.9222,12.2987z M16.4322,11.307c-0.0567-0.1417-0.1983-0.425-0.2833-0.5667
		c-0.255-0.4817-1.7568-3.5702-1.8701-3.7119c-0.1133,0.1133-0.9634,1.8701-1.1051,2.1535c-0.17,0.3684-0.34,0.68-0.5384,1.0484
		c-0.1133,0.2267-0.4534,0.8784-0.51,1.0767H16.4322z M9.0084,5.4416C8.3851,5.2149,8.1017,6.15,8.6967,6.3767
		C9.2918,6.575,9.6601,5.6683,9.0084,5.4416z M9.2351,2.3531C9.2068,2.2114,8.9518,1.7014,8.8668,1.6164
		c-0.085,0.085-0.3684,0.6234-0.3967,0.765l0.3967,0.3684L9.2351,2.3531z M16.1489,8.5585c0.3684,0.765,0.7367,1.4734,1.1334,2.2668
		c0.2267,0.4534,0.5667,0.9067,0.34,1.2467c-0.17,0.2833-0.595,0.6517-0.8501,0.8501c-1.4451,1.1334-3.6269,1.1334-5.072-0.0567
		c-0.1983-0.1417-0.7367-0.6517-0.8501-0.8784c-0.085-0.255,0.085-0.4817,0.17-0.6517c0.3117-0.68,2.4935-4.9586,2.5218-5.1286
		c-0.34-0.2267-0.3967-0.3117-0.6234-0.68c-0.17,0-2.4935,0.51-2.5785,0.5667c-0.1133,0.085,0,0.34-0.3684,0.765
		c-0.085,0.1133-0.17,0.17-0.2834,0.255C9.6035,7.17,9.4051,7.2267,9.3485,7.34l0.0283,7.9055c0.2834,0.0283,0.8217-0.0567,1.0767,0
		c0.2267,0.0567,0.4817,0.3684,0.595,0.51l1.1051,1.1051c0.2267,0.255,0.17,0.595-0.0567,0.765
		c-0.1983,0.1417-0.7084,0.085-1.0201,0.085H6.6566c-0.3117,0-0.8217,0.0567-1.0201-0.085c-0.255-0.17-0.3117-0.51-0.085-0.765
		c0.3684-0.3684,0.7367-0.7367,1.1334-1.1051c0.1133-0.1133,0.3684-0.4534,0.595-0.4817c0.3117-0.0567,0.765,0,1.0767,0V7.3117
		c-0.1133-0.085-0.2833-0.17-0.425-0.255c-0.17-0.1417-0.1983-0.2267-0.34-0.3684C7.3933,6.7167,5.9199,7.0567,5.5799,7.1417
		C4.7015,7.34,4.9282,7.2267,4.7582,7.5384c-0.1417,0.255-0.34,0.5384-0.595,0.6234c0.0567,0.17,0.1983,0.4534,0.2834,0.6234
		c0.6234,1.3034,1.3317,2.6352,1.9835,3.9952c0.1417,0.2834,0.595,0.9067,0.3967,1.2467c-0.1417,0.255-0.6234,0.68-0.8501,0.8501
		c-1.5018,1.1617-3.6269,1.1334-5.1003-0.0283c-0.1983-0.17-0.7367-0.6517-0.8501-0.9067c-0.085-0.2834,0.0567-0.4534,0.1417-0.6517
		l1.4168-2.8335c0.17-0.34,1.1051-2.1251,1.1334-2.2951c-0.255-0.1133-0.4817-0.3967-0.6234-0.68
		c-0.51-1.2184,0.765-1.4168,0.8501-0.6234c0.0567,0.3684,0.34,0.68,0.7367,0.4534C4.0781,7.085,3.7948,6.6883,4.1631,6.4617
		c0.1417-0.0567,0.8501-0.1983,1.0767-0.255c2.6635-0.5667,2.0118-0.34,2.2668-0.9067c0.2834-0.595,0.68-0.68,0.8501-0.8217
		c0.0283-0.17,0.0567-0.7367,0-0.8501c-0.0567-0.085-0.765-0.7367-0.8784-0.9067c-0.17-0.1983-0.085-0.425,0.0283-0.6517
		c0.17-0.3684,0.3684-0.765,0.5667-1.1617c0.255-0.4817,0.3684-0.9351,0.8217-0.9067c0.2833,0,0.3684,0.1983,0.4817,0.3967
		l0.8501,1.7284c0.1417,0.255,0.1417,0.425-0.0283,0.6517C9.3201,3.7698,9.2918,3.2315,9.3201,4.4782
		c0.1417,0.1133,0.2834,0.1417,0.4534,0.255c0.1133,0.1133,0.2267,0.2834,0.34,0.3684c0.7367-0.1133,1.5301-0.3117,2.2385-0.4817
		c0.255-0.0567,0.9067-0.2267,1.1051-0.1417c0.4534,0.17,0.1983,0.595,0.51,0.8217c0.3684,0.2834,0.7367,0,0.7934-0.3684
		c0.0283-0.2267,0.085-0.34,0.2267-0.425c0.17-0.1133,0.3684-0.1133,0.5384,0c0.3117,0.17,0.255,0.6234,0.085,0.9917
		c-0.1983,0.4817-0.51,0.5667-0.6234,0.7367c0.085,0.1983,0.1983,0.3967,0.2834,0.595L16.1489,8.5585z"></path>
        </symbol>

        <symbol id="passport" viewBox="0 0 15.3009 17.8307" style="enable-background:new 0 0 15.3009 17.8307;" xml:space="preserve">
	<path d="M3.4002,3.4077c0.2267-0.0567,5.0436-0.0283,5.7237,0c3.1452,0,3.1452-0.3117,3.1452,1.1617v11.504
		c0,0.34,0.1417,0.8501-0.3967,0.9917c-0.2267,0.0567-1.1051,0.0283-1.4168,0l-4.3069,0.0283c-0.4817,0-2.6068,0.0567-2.8618-0.085
		c-0.3967-0.17-0.3117-0.6234-0.3117-1.1051s0-0.9351,0-1.4168c0-1.9268,0-3.8536,0-5.752V4.3995
		C2.9752,3.8611,2.8902,3.5777,3.4002,3.4077z M10.0306,10.8315l-0.0567-0.17c-0.1417-0.5384-0.3967-0.9634-0.425-1.1334
		c0.6517,0.2834,1.3884,1.5018,1.4168,2.3518h-0.7934C10.144,11.4832,10.059,11.1999,10.0306,10.8315z M9.6339,14.9401
		c-0.085,0.0283-0.0283,0.0283-0.0567-0.0283c0.1417-0.3684,0.2834-0.6234,0.3684-1.0484c0.1133-0.3684,0.17-0.7934,0.2267-1.2184
		h0.7934C10.9373,13.6084,10.1723,14.5718,9.6339,14.9401z M5.6954,14.9118c0.0283,0.085,0.0283,0.0283,0,0.0567
		C5.157,14.6568,4.3353,13.58,4.3069,12.6166l0.8217,0.0283C5.1853,13.58,5.327,14.1467,5.6954,14.9118z M5.922,13.0417
		l-0.0283-0.3684h1.3601v2.8052l-0.085-0.0283c-0.17-0.0283-0.425-0.3117-0.51-0.3967c-0.1133-0.17-0.2267-0.34-0.34-0.5667
		C6.177,14.2317,5.8937,13.3817,5.922,13.0417z M8.0755,15.4785c-0.085-0.0567-0.0283-0.085-0.0283-0.34
		c-0.0283-0.425-0.0283-2.3518,0-2.4652l1.3317-0.0283L9.3506,13.07c0.0283,0.3684-0.255,1.1617-0.3967,1.4168
		C8.7839,14.8551,8.4439,15.3368,8.0755,15.4785z M4.0236,4.9095c0.085,0.255,0.4534,0.2267,0.765,0.2267h6.0354
		c0.3117,0,0.5667-0.1133,0.4817-0.4817c-0.1133-0.3117-0.4817-0.255-0.7934-0.255H5.4687c-0.3117,0-0.6517,0-0.9917,0
		C4.1653,4.3995,3.9102,4.5411,4.0236,4.9095z M11.2774,6.8079c0.085-0.17,0.0567-0.51-0.425-0.51H4.817
		c-0.3117,0-0.6517-0.0567-0.765,0.1983c-0.17,0.34,0.085,0.5384,0.3967,0.5384c1.9551,0.0283,4.0803,0,6.0354,0
		C10.824,7.0346,11.164,7.0913,11.2774,6.8079z M8.0188,9.0181c0.2267,0.0283,0.51,0.34,0.595,0.4534
		c0.17,0.1983,0.2833,0.3684,0.3967,0.6517c0.1983,0.4534,0.425,1.1901,0.3967,1.7568H8.0188V9.0181z M5.8654,11.8799
		c0-0.5384,0.1983-1.3317,0.3967-1.7568c0.17-0.3684,0.6234-1.0484,1.0201-1.1051l-0.0283,2.8618H5.8654z M5.6954,9.6131
		c-0.3117,0.68-0.51,1.4168-0.5667,2.2668H4.3069c0.0283-0.8217,0.7367-1.9835,1.3601-2.3235L5.6954,9.6131z M11.6741,12.73
		c0.2834-2.4085-1.5018-4.3069-3.5702-4.5336C5.667,7.9697,3.8536,9.6981,3.5986,11.7949
		c-0.3117,2.2951,1.4734,4.3069,3.5702,4.5053C9.6056,16.5269,11.4474,14.8551,11.6741,12.73z M4.9303,2.6143
		C5.1853,2.501,5.582,2.3877,5.837,2.3027c0.3117-0.1133,0.5384-0.1983,0.8501-0.2834l3.4569-1.2184
		c0.4534-0.1417,0.425,0.3117,0.425,0.68s0.0283,0.8217,0,1.1617c-0.17,0.0283-5.412,0.0283-5.5537,0
		C4.9303,2.6427,4.9586,2.6427,4.9303,2.6143z M11.2774,17.8303c0.595,0,0.9351,0,1.3034-0.3117
		c0.3117-0.255,0.4817-0.6517,0.4817-1.1617V4.9945c0-0.765,0.085-1.4168-0.3117-1.8985c-0.595-0.68-1.3034-0.3684-1.4168-0.51
		c-0.0567-0.1417-0.0283-0.425-0.0283-0.6234c0-0.7934,0.1133-1.5868-0.6234-1.8985c-0.4534-0.1983-1.0767,0.1133-1.4734,0.255
		L3.8536,2.1893c-0.5667,0.1983-0.8501,0.255-1.1617,0.6234c-0.34,0.425-0.425,0.7934-0.425,1.3884v11.1924
		c0,0.8217-0.1133,1.5584,0.3967,2.0685c0.425,0.3967,0.7934,0.3684,1.5018,0.3684H11.2774z"></path>
</symbol>

        <symbol id="phone" viewBox="0 0 15.3009 17.8861">
            <path d="M3.5986,16.066v-1.4451h7.9622c0,0,0,0.8784,0,1.0201c0,0.4534-0.0283,0.7084-0.255,1.0201
			c-0.4534,0.6234-1.3884,0.4534-2.1818,0.4534H5.1853c-0.4817,0-0.7367,0.0283-1.0767-0.2267
			C3.8819,16.746,3.6552,16.4343,3.5986,16.066z M7.2538,9.7473h0.8217c0.1983,0,0.34,0.1417,0.34,0.34v0.8501
			c0,0.17-0.1417,0.34-0.34,0.34H7.2538c-0.1983,0-0.34-0.17-0.34-0.34v-0.8501C6.9138,9.8889,7.0554,9.7473,7.2538,9.7473z
			 M4.9586,9.7473h0.8217c0.1983,0,0.34,0.1417,0.34,0.34v0.8501c0,0.17-0.1417,0.34-0.34,0.34H4.9586c-0.1983,0-0.34-0.17-0.34-0.34
			v-0.8501C4.6186,9.8889,4.7603,9.7473,4.9586,9.7473z M9.5206,7.3388h0.8501c0.17,0,0.34,0.1417,0.34,0.34v0.8501
			c0,0.17-0.17,0.34-0.34,0.34H9.5206c-0.17,0-0.34-0.17-0.34-0.34V7.6788C9.1806,7.4805,9.3506,7.3388,9.5206,7.3388z
			 M7.2538,7.3388h0.8217c0.1983,0,0.34,0.1417,0.34,0.34v0.8501c0,0.17-0.1417,0.34-0.34,0.34H7.2538c-0.1983,0-0.34-0.17-0.34-0.34
			V7.6788C6.9138,7.4805,7.0554,7.3388,7.2538,7.3388z M4.9586,7.3388h0.8217c0.1983,0,0.34,0.1417,0.34,0.34v0.8501
			c0,0.17-0.1417,0.34-0.34,0.34H4.9586c-0.1983,0-0.34-0.17-0.34-0.34V7.6788C4.6186,7.4805,4.7603,7.3388,4.9586,7.3388z
			 M9.5206,4.987h0.8501c0.17,0,0.34,0.1417,0.34,0.34V6.177c0,0.1983-0.17,0.34-0.34,0.34H9.5206c-0.17,0-0.34-0.1417-0.34-0.34
			V5.327C9.1806,5.1286,9.3506,4.987,9.5206,4.987z M7.2538,4.987h0.8217c0.1983,0,0.34,0.1417,0.34,0.34V6.177
			c0,0.1983-0.1417,0.34-0.34,0.34H7.2538c-0.1983,0-0.34-0.1417-0.34-0.34V5.327C6.9138,5.1286,7.0554,4.987,7.2538,4.987z
			 M4.9586,4.987h0.8217c0.1983,0,0.34,0.1417,0.34,0.34V6.177c0,0.1983-0.1417,0.34-0.34,0.34H4.9586
			c-0.1983,0-0.34-0.1417-0.34-0.34V5.327C4.6186,5.1286,4.7603,4.987,4.9586,4.987z M7.5938,15.0459
			c0.425,0,0.7934,0.3684,0.7934,0.7934c0,0.4534-0.3684,0.7934-0.7934,0.7934c-0.4534,0-0.8217-0.34-0.8217-0.7934
			C6.7721,15.4143,7.1404,15.0459,7.5938,15.0459z M8.9822,2.1535c0.1133-0.2834-0.085-0.4817-0.3684-0.4817H6.7437
			c-0.3117,0-0.5384,0-0.6234,0.255C6.007,2.1818,6.2621,2.4085,6.4887,2.4085c0.255,0.0283,0.6234,0,0.9067,0
			c0.3117,0,0.6234,0,0.9351,0C8.6705,2.4085,8.8972,2.4368,8.9822,2.1535z M3.5986,4.0803V3.9669h7.9622
			c-0.0283,2.3235,0,6.6871,0,9.0389c0,0.9351,0.085,0.8501-0.255,0.8501H4.1653c-0.4534,0-0.5667,0.0567-0.5667-0.1133V4.0803z
			 M3.5986,2.2951c0-1.1617,0.425-1.5584,1.5584-1.5584h5.072c0.8217,0,1.3317,0.4817,1.3317,1.3317v1.1617H3.6269
			C3.5419,3.2302,3.5986,2.4085,3.5986,2.2951z M2.8618,2.2385v13.2608c0,0.9067,0.1133,1.2751,0.6234,1.7851
			c0.7367,0.7084,1.5301,0.595,2.6635,0.595h3.5702c1.0484,0,1.4451-0.085,1.9835-0.6234c0.595-0.6234,0.595-1.0484,0.595-2.1251
			V3.0319c0-1.0201,0.1133-1.5301-0.425-2.2385C11.334,0.1417,10.7673,0,9.9739,0H5.1003C3.7119,0,2.8618,0.8501,2.8618,2.2385z"></path>
        </symbol>

        <symbol id="town" viewBox="0 0 21.1163 17.8667">
            <path d="M16.9778,9.3222l-0.0283,7.6788h-3.0602V7.9622C14.9377,8.4155,15.9294,8.8689,16.9778,9.3222z
			 M5.2471,11.8724l-0.1133,0.0567c-0.1133,0.1983-0.1417,0.1417-0.1417,0.425c0,0.1983,0,0.3967,0,0.595
			c0,0.3684,0.3117,0.6234,0.6234,0.425c0.2834-0.17,0.2267-0.595,0.2267-0.9634C5.8421,12.0141,5.6438,11.7874,5.2471,11.8724z
			 M8.1373,6.092c0.0567,0.17-0.0283,0,0.0283,0.0567c0.0283,0.0567,0.0283,0.0283,0.0567,0.085
			c0.1417,0.2267,0.5384,0.2267,0.7084-0.0283c0.085-0.17,0.085-0.9351,0.0283-1.1334c-0.1133-0.3117-0.5667-0.34-0.7367-0.085
			C8.0806,5.1853,8.1373,5.837,8.1373,6.092z M8.3073,8.9255v0.0283c0.0283,0,0.0283,0.0283,0.0283,0.0283
			c0.0567,0.0283,0,0,0.085,0.0283c0.7084,0.0567,0.595-0.68,0.5384-1.2751V7.7071V7.6788C8.9306,7.6221,8.9306,7.6505,8.9023,7.6221
			c-0.1983-0.255-0.4817-0.255-0.68,0c-0.0283,0-0.0283,0-0.0283,0c0,0.0283-0.0283,0.0283-0.0283,0.0283
			c-0.0283,0.0567,0,0-0.0283,0.085c0,0.2267,0,0.4534,0,0.68C8.1373,8.6989,8.1373,8.7839,8.3073,8.9255z M5.8138,14.5359
			c-0.0567-0.1983,0.0283,0-0.0283-0.085c-0.0283-0.0283,0-0.0283-0.0283-0.0567c-0.1983-0.2267-0.6234-0.2267-0.7367,0.1133
			c-0.0567,0.1417-0.0567,0.9351,0,1.0767c0.1417,0.255,0.595,0.3117,0.765,0.0283C5.8705,15.4426,5.8421,14.7342,5.8138,14.5359z
			 M10.7724,11.4757c0.0283-0.0283,0,0,0.0567-0.0567c0.0283-0.085-0.0283,0.1133,0-0.085c0.0283-0.2267,0.0567-0.9067-0.0567-1.1051
			c-0.1983-0.255-0.595-0.2267-0.7367,0.0567c-0.0567,0.1417-0.0567,0.9634,0,1.1051
			C10.1774,11.7024,10.5457,11.7024,10.7724,11.4757z M12.6992,7.7071c-0.0283-0.1133,0-0.0567-0.085-0.1133
			c-0.2267-0.2834-0.6234-0.17-0.7084,0.1133c-0.0567,0.17-0.0567,0.9634,0.0283,1.1051c0.17,0.3117,0.6234,0.255,0.7367-0.0283
			C12.7559,8.6422,12.7559,7.8772,12.6992,7.7071z M5.8421,9.8039c-0.0283-0.0567,0,0-0.0283-0.085
			c-0.0567-0.0567-0.0283-0.0283-0.085-0.0567c-0.17-0.255-0.5667-0.2267-0.7084,0.0567c-0.0567,0.17-0.0567,0.9634,0,1.1051
			c0.1417,0.3117,0.5667,0.3117,0.7367,0.085C5.8988,10.7107,5.8421,10.059,5.8421,9.8039z M0.0901,17.1711H0.0618
			c0,0.0283-0.0283,0.0283-0.0283,0.0283c-0.0283,0.0567,0,0-0.0283,0.085c-0.0567,0.595,0.3684,0.5667,0.8217,0.5667
			c5.1853,0.0283,10.4273-0.0283,15.6126,0c0.9351,0,1.8985,0,2.8335,0c0.3967,0,1.0484,0.085,1.2751-0.1417
			c0.1417-0.1417,0.1417-0.3967,0.0283-0.5384c-0.1133-0.17-0.255-0.17-0.5384-0.17V15.726
			c0.7367-0.4534,1.0484-1.2184,1.0767-2.0401c0.0283-0.8501-0.34-2.6068-0.765-3.2585c-0.255-0.34-0.3967-0.4817-0.9634-0.4534
			c-0.0567,0.0283,0.0283-0.0283-0.0567,0.0567c-0.085,0.0283-0.0283,0-0.085,0.0283c-0.7367,0.4534-1.4168,2.8902-1.0201,4.4486
			c0-0.0283-0.0283-0.0283-0.0283-0.0283l0.0567,0.1417c0.17,0.51,0.4534,0.9067,0.9067,1.1051l0.0283,1.2751h-1.3601
			c-0.0567-0.8501-0.0283-1.8418,0-2.6918c0-0.9067-0.0283-1.8418,0-2.7485c0-0.3684,0.0283-2.4652-0.0283-2.6635
			c-0.085-0.255-0.5667-0.3967-0.8501-0.51c-1.0201-0.4534-2.0401-0.9067-3.0602-1.3601c-0.0567-0.7934,0-1.7284,0-2.5502
			c0-0.8784,0-1.7284,0-2.6068c0-0.3117,0.0283-0.9634,0-1.2751c-0.0567-0.3967-0.425-0.425-0.765-0.2267l-5.752,3.2585
			c-0.4817,0.255-0.3967,0.2834-0.3967,0.9067c0,0.8784,0.0283,1.7568,0,2.6068C5.7004,7.6788,4.4537,8.2455,3.207,8.8405
			c-0.3117,0.085-0.1983,0.9917-0.1983,1.3317c0.0283,1.5018,0.0567,3.4002,0,4.7886c-0.1417,0.085-0.1417,0.1417-0.255,0.2267
			c-0.3117-0.085-0.34-0.1417-0.68-0.0567c-0.0283,0.0283-0.0283,0.0283-0.085,0.0567c-0.0283,0.0283-0.0567,0.0283-0.085,0.0567
			c-0.1983,0.0283-0.2834,0.3117-0.4817,0.6234c-0.085,0.1133-0.085,0.2267-0.1417,0.2833
			c-0.0567,0.1133-0.1417,0.1133-0.1983,0.1983c-0.0567,0.0567-0.1133,0.17-0.17,0.2267c-0.085,0.0567-0.17,0.085-0.2267,0.17
			c-0.085,0.0567-0.1133,0.1417-0.17,0.2267C0.2884,17.0577,0.2318,17.001,0.0901,17.1711z M15.7877,13.2608
			c0-0.0283,0-0.0283,0.0283-0.0283v-0.0283c0.0283-0.085,0,0,0.0283-0.1133c0-0.255,0.0567-0.8501-0.0567-1.0484
			c-0.1417-0.2267-0.595-0.2834-0.7367,0.0283c-0.0567,0.1417-0.0567,0.9917,0,1.1334
			C15.1927,13.5158,15.5894,13.5158,15.7877,13.2608z M15.8444,14.5642c0-0.1417,0-0.085-0.085-0.17
			c-0.085-0.255-0.595-0.2267-0.7084,0.0567c-0.0567,0.17-0.0567,0.9634,0,1.1051c0.1133,0.3117,0.5667,0.3117,0.7367,0.0567
			C15.9011,15.4143,15.8444,14.8476,15.8444,14.5642z M10.0074,8.0472c0,0.3684-0.0567,0.7934,0.2267,0.9351
			c0.17,0.085,0.3684,0.0283,0.4817-0.0567c0.1417-0.1417,0.1417-0.2834,0.1417-0.51c0-0.3684,0.0567-0.8217-0.255-0.9351
			c-0.17-0.085-0.3684-0.0283-0.4534,0.0567C10.0357,7.6505,10.0074,7.8205,10.0074,8.0472z M10.2907,4.8453
			c-0.3684,0.1417-0.2833,0.51-0.2833,0.9351c0,0.3967,0.1417,0.7367,0.5667,0.595c0.3684-0.1133,0.2834-0.5384,0.2834-0.9351
			C10.8574,5.0153,10.6874,4.7036,10.2907,4.8453z M12.2175,4.8453c-0.425,0.085-0.34,0.425-0.34,0.8784
			c0,0.1983-0.0283,0.3684,0.085,0.51c0.085,0.085,0.255,0.1983,0.4534,0.1417c0.3684-0.085,0.3117-0.5384,0.3117-0.9067
			C12.7275,5.157,12.6709,4.7036,12.2175,4.8453z M15.8444,9.8323c-0.0283-0.0283-0.0283-0.0283-0.0567-0.085
			c0-0.0567,0.0283,0.0283,0-0.0567c-0.2267-0.2834-0.595-0.255-0.7367,0c-0.0567,0.1417-0.085,0.9634,0,1.1334
			c0.1133,0.3117,0.5384,0.3117,0.7084,0.085C15.9011,10.7107,15.8444,10.0873,15.8444,9.8323z M8.1656,11.3624
			c0.085,0.34,0.5384,0.34,0.7367,0.085c0.1133-0.1417,0.1133-0.9067,0.0567-1.1051c-0.1133-0.34-0.5667-0.3967-0.7367-0.1133
			C8.1089,10.3706,8.0806,11.164,8.1656,11.3624z M11.8775,11.249c0.0567,0.3967,1.0201,0.9351,0.8501-0.8217
			C12.6709,10.0023,11.6791,9.5489,11.8775,11.249z M1.8185,3.9102c2.2668-0.0283,2.8618-0.0283,3.6269-0.0283
			c1.3034,0,1.3317-2.4085-0.4534-2.4085C4.9637,0.595,4.3404,0,3.292,0C2.5553,0,1.7335,0.51,1.7052,1.6151
			C0.1751,1.6434,0.2034,3.8819,1.8185,3.9102z M1.8185,3.1452C3.0086,3.1169,4.227,3.0885,5.4454,3.0885
			c0.2267,0,0.3117-0.8217-0.4534-0.8217H4.1987v-0.765c0-0.5667-0.3967-0.7084-0.9067-0.7084s-0.7934,0.34-0.7934,0.8217
			l-0.0283,0.765H1.7335c-0.1417,0.0283-0.2834,0.0567-0.34,0.1983c-0.0567,0.1133-0.0283,0.255,0.0283,0.3684
			C1.5069,3.0885,1.6485,3.1169,1.8185,3.1452z M10.8574,13.4592h1.0201v3.5419l-1.0201-0.0283V13.4592z M8.9873,13.4308
			l1.0201,0.0283v3.5419H8.9873V13.4308z M4.8787,16.6894h0.0567l0.0283,0.1133l0.0567,0.1983c-0.5667,0-1.1334,0-1.7001,0
			c-0.2267,0-1.4734,0.0567-1.6151-0.0283c0.0567-0.1133,0.34-0.085,0.425-0.3684c0.1133-0.4534-0.1417-0.0567,0.2267-0.51h0.0283
			c0-0.0283,0-0.0283,0-0.0283c0.425,0.1983,0.4817-0.0567,0.7934,0c0.1133,0.0283,0.1983,0.1417,0.425,0.0567
			c0.17-0.0567,0.0567-0.1417,0.3117-0.1133c0.1417,0.0567-0.0283,0.3684,0.595,0.3967C4.567,16.576,4.6804,16.6894,4.8787,16.6894z
			 M6.9472,8.1038v8.8972h-0.51c-0.17-0.3117-0.1417-0.3967-0.3967-0.5667c-0.085-0.0567-0.0283-0.0283-0.085-0.0567
			c0,0-0.0283,0-0.0283-0.0283c0,0,0,0-0.0283,0c-0.2267-0.085-0.17-0.0283-0.3117-0.2267c-0.085-0.085-0.17-0.1417-0.3117-0.1983
			c-0.1133-0.0283-0.085,0-0.1417-0.085c-0.1417-0.085-0.1417-0.1417-0.3117-0.2267c-0.34-0.1417,0-0.17-0.6517-0.4534
			c-0.085-0.0283-0.2267-0.1417-0.3117-0.2267v-5.497C4.9637,9.0106,5.8705,8.5005,6.9472,8.1038z M20.1797,12.7225
			c0.2833,1.8134-0.4534,2.7202-0.9634,1.9835c-0.34-0.5384-0.3117-1.3317-0.1983-2.0118c0.085-0.4817,0.34-1.5584,0.5667-1.8134
			C19.8963,11.0507,20.1513,12.5524,20.1797,12.7225z M13.0392,1.4168V17.001h-0.3117c-0.0567-1.0484,0-2.2668,0-3.3435
			c0-1.2184,0.1983-1.0767-2.2951-1.0484c-2.4652,0-2.2951-0.1983-2.2951,1.0767c0,1.0767,0.0283,2.2101,0,3.3152l-0.34-0.0283
			L7.8256,4.3636C7.9389,4.2786,12.8692,1.4451,13.0392,1.4168z"></path>
        </symbol>

        <symbol id="policeman" viewBox="0 0 15.3009 17.7957">
            <path d="M13.4592,11.3242c0.1133,0.1417,0.0567,1.2184,0.0567,1.3601c0,0.5384,0.0283,4.0236-0.0283,4.2219h-1.7568
			c-0.0567-0.1983-0.0283-2.7485-0.0283-3.1452c0-0.34-0.4534-0.51-0.7084-0.2833c-0.2267,0.1983-0.17,0.7084-0.17,1.0484
			c0,0.765,0.0283,1.5868,0,2.3518H6.8288c0.085-0.1417,0.6234-0.6517,0.765-0.7934c0.2834-0.2834,0.5384-0.51,0.8217-0.7934
			c1.2751-1.3317,2.6918-2.6635,3.9669-3.9952c0.1133-0.1133,0.68-0.7084,0.8217-0.765
			C13.3175,10.6725,13.4875,11.0975,13.4592,11.3242z M5.3837,16.8779H3.9102c0.085-0.1417,0.3684-0.3684,0.4817-0.4817
			l3.2302-3.2302c0.6234-0.6234,1.2467-1.2184,1.8701-1.8418l1.6151-1.6151c0.1133-0.1417,0.085-0.1417,0.34-0.1417
			s0.9067,0.1133,1.0484,0.3117c-0.1133,0.17-3.4002,3.4285-3.5135,3.5419L5.667,16.7362
			C5.582,16.8212,5.5537,16.8779,5.3837,16.8779z M4.4486,15.0361v-1.0767c0-0.3117-0.1133-0.6234-0.51-0.5667
			c-0.4817,0.0567-0.3684,0.765-0.3967,1.3601v0.9634c0,0.3117,0,0.255-0.17,0.425c-0.1133,0.085-0.1983,0.17-0.2834,0.2834
			c-0.5667,0.5667-0.3117,0.4817-1.3034,0.4534c-0.0567-0.8217,0-3.3152,0-4.3353v-0.9917c0-1.1901,0.8501-2.0401,2.1251-2.0401
			h6.0354c-0.085,0.17-4.2219,4.2503-4.7886,4.8453C5.0153,14.4977,4.5903,14.9511,4.4486,15.0361z M6.6871,6.1389
			c2.4368,0.0283,3.1735-1.5868,3.6552-1.8418v1.8984c0,1.4168-1.1051,2.4935-2.5218,2.4935H7.5938
			c-1.5868,0-2.6352-1.0201-2.6635-2.5502H6.6871z M3.0885,5.2605c0.0283-0.1417,0.255-0.3117,0.3967-0.4817l0.7934-0.8217
			c0.17-0.17,0.3117-0.34,0.4534-0.34c0.8784,0,4.3353-0.0283,4.9303,0c-0.1133,0.17-0.3684,0.3684-0.51,0.51
			c-0.5667,0.595-1.0484,0.9634-1.9835,1.0767C6.6871,5.2605,3.7969,5.2322,3.0885,5.2605z M10.569,2.7103
			c-0.2834,0.0567-0.8217,0-1.1334,0H4.9586c-0.2834,0.0283-0.255,0-0.3967-0.17C4.4769,2.427,4.4203,2.342,4.3353,2.2286
			c-0.17-0.2267-0.9067-1.1334-0.9634-1.3317h8.5005C11.8441,1.0102,10.7673,2.4837,10.569,2.7103z M5.1286,8.5757
			C4.2503,8.6324,3.5702,8.4907,2.7768,8.774c-0.595,0.2267-1.0767,0.6517-1.3884,1.1334c-0.425,0.68-0.4534,1.1051-0.4534,2.0685
			v4.987c0,0.9917,0.1133,0.8217,1.7001,0.8217h10.0023c0.425,0,0.8784,0,1.3034,0c0.4817-0.0283,0.4534-0.3684,0.4534-0.8217v-4.987
			c0-0.9351-0.0567-1.3884-0.4817-2.0401c-0.3117-0.4534-0.765-0.8501-1.4168-1.1051c-0.7367-0.3117-1.4451-0.17-2.2951-0.1983
			c0.0283-0.0567,0.4534-0.51,0.7084-1.0201c0.1983-0.3967,0.3117-0.8784,0.3117-1.3884V3.5887c0-0.1983,0-0.2267,0.085-0.3684
			l1.6434-2.2385c0.1417-0.17,0.3117-0.34,0.2834-0.6234c-0.0567-0.2834-0.2834-0.34-0.5384-0.34c-0.595,0-1.1617,0-1.7284,0
			c-2.3235,0-4.647,0-6.9704,0c-0.3117,0-1.5018-0.0567-1.7001,0.0283c-0.1983,0.085-0.34,0.3684-0.2267,0.5667
			C2.1251,0.7269,3.7686,2.9087,3.8819,3.107L1.9551,5.0905c-0.1417,0.1133-0.425,0.3117-0.3967,0.6234
			c0.0283,0.3117,0.3117,0.3967,0.595,0.3967c0.5667,0,1.3601-0.0567,1.9268,0c0.0283,0.2834,0.0283,0.51,0.085,0.7934
			C4.2786,7.3573,4.4769,7.754,4.732,8.1223c0.0567,0.085,0.1133,0.17,0.1983,0.2267C5.0153,8.434,5.072,8.4907,5.1286,8.5757z"></path>
        </symbol>

        <symbol id="drugs" viewBox="0 0 19.046 17.8634">
            <path d="M1.8418,15.0469c0.085-0.17,0.7084-0.7367,0.8784-0.9351c0.17-0.1417,0.7934-0.8217,0.9351-0.8784
			l0.9917,0.9917l-1.8134,1.8134C2.7202,15.982,1.8985,15.1603,1.8418,15.0469z M17.4544,5.1013
			c0.1417,0.1133,0.595,1.1051,0.7084,1.3601c0.6234,1.5868-2.0118,1.6151-1.4168,0.0283
			C16.8877,6.1214,17.2277,5.413,17.4544,5.1013z M17.3127,3.9679c-0.2834,0.1417-0.6234,0.8217-0.7934,1.1334
			c-0.4817,0.9067-1.0201,1.9268-0.255,2.7768c0.7934,0.8784,1.9268,0.7084,2.5218-0.17c0.34-0.51,0.3117-0.9351,0.1133-1.5301
			c-0.2267-0.595-0.6517-1.3317-0.9917-1.8985C17.7944,4.0813,17.6244,3.7979,17.3127,3.9679z M14.1109,6.4047
			c-0.0567,0.1417-0.3684,0.425-0.4817,0.5384l-5.5253,5.5253c-0.3684,0.34-0.68,0.68-1.0201,1.0201c-0.17,0.17-0.34,0.34-0.51,0.51
			c-0.1133,0.1133-0.3967,0.425-0.51,0.4817l-2.0401-2.0118c-0.085-0.1133-0.595-0.5667-0.6517-0.68l0.6517-0.595
			c0.1417,0.0567,1.1051,1.0767,1.3317,1.2751c0.425,0.425,0.9634-0.1417,0.5384-0.5667c-0.2267-0.255-1.2184-1.1901-1.2751-1.3034
			c0.0283-0.085,0.425-0.51,0.5384-0.5384c0.17,0.1417,0.34,0.3117,0.4534,0.4534c0.4534,0.4534,1.0484-0.085,0.5667-0.5667
			c-0.1417-0.17-0.3117-0.3117-0.4534-0.4534c0.0567-0.1133,0.4534-0.51,0.5384-0.5384c0.2834,0.2267,0.595,0.5667,0.8784,0.8501
			c0.255,0.2834,0.68,0.8501,1.0484,0.4534c0.34-0.3967-0.3117-0.8217-0.51-1.0484C7.5371,9.0682,6.8854,8.4732,6.8571,8.3315
			c0.085-0.1133,0.3967-0.4534,0.51-0.51c0.2267,0.1417,0.68,0.9351,1.1051,0.51c0.4534-0.4534-0.3967-0.7934-0.51-1.1051
			c0.085-0.1133,0.425-0.4534,0.5384-0.51c0.1133,0.0567,1.0767,1.0484,1.3034,1.3034c0.425,0.3967,1.0201-0.1417,0.5384-0.595
			c-0.2267-0.2267-1.2184-1.2184-1.2751-1.3034C9.1806,5.9797,9.4923,5.668,9.6056,5.583c0.2267,0.1417,0.68,0.9351,1.1051,0.51
			c0.425-0.425-0.3967-0.8501-0.5384-1.1051l1.2751-1.2467c0.1133,0.0567,1.1617,1.1617,1.3317,1.3317
			C13.0058,5.328,13.9975,6.2347,14.1109,6.4047z M13.6575,4.7896c0.1133-0.1417,3.0885-3.0885,3.3719-3.3719
			c0.425-0.425,1.1051-0.9351,0.7084-1.3034c-0.3117-0.2834-0.595,0.0283-0.7367,0.1983l-3.9102,3.8819
			c-0.1983-0.085-1.2467-1.2751-1.4451-1.3884c-0.255-0.1133-0.425,0-0.5384,0.1417L7.2254,6.8014
			C6.2621,7.7365,5.3553,8.6999,4.4203,9.6349l-1.7851,1.7851c-0.51,0.51-0.085,0.6517,0.4534,1.2184l-1.8418,1.8134
			c-0.1133-0.1133-0.255-0.2267-0.3684-0.3684c-0.1417-0.1133-0.255-0.2834-0.4817-0.2834c-0.1983,0-0.3684,0.17-0.3967,0.3684
			c0,0.255,0.17,0.3684,0.2834,0.4817l2.9752,2.9752c0.1133,0.1133,0.2267,0.2834,0.51,0.2267
			c0.17-0.0283,0.3117-0.1983,0.3117-0.425c-0.0283-0.3117-0.595-0.6234-0.6517-0.8217l1.7851-1.7851
			c0.2267,0.085,0.51,0.6234,0.8217,0.6517c0.255,0,0.34-0.1417,0.4534-0.255l8.1038-8.1322c0.1417-0.1133,0.255-0.2267,0.3684-0.34
			c0.1417-0.1417,0.1983-0.3117,0.085-0.51c-0.085-0.17-0.5384-0.5667-0.68-0.7367C14.1959,5.3563,13.7425,4.9313,13.6575,4.7896z"></path>
        </symbol>

        <symbol id="lupa" viewBox="0 0 17.744 17.7289">
            <path class="st0" d="M7.104,12.0572l0.9634,0.5667l0,0c0.7934,0.425,1.6718,0.6517,2.5785,0.7084
		c0.4534,0.0283,0.9351,0,1.4168-0.0567c1.1051-0.17,2.1251-0.595,3.0035-1.2751c0.8501-0.6234,1.5301-1.4451,1.9835-2.3801
		c0.9067-1.8418,0.9351-3.9669,0.0283-5.837c-0.17-0.3684-0.3684-0.7084-0.6234-1.0201c-0.1983-0.2834-0.425-0.5667-0.68-0.7934
		c-0.9067-0.9351-2.0401-1.5584-3.3152-1.8134c-0.9634-0.2267-2.0118-0.1983-2.9752,0.0283
		c-1.0201,0.255-1.9835,0.7367-2.7768,1.4168C6.1123,2.14,5.6023,2.7633,5.2056,3.4434c-0.51,0.9351-0.7934,1.9835-0.8217,3.0602
		c0,0.5384,0.0283,1.0767,0.17,1.6151C4.6672,8.657,4.8656,9.1954,5.1206,9.6771c0,0.0283,0.0283,0.085,0.0567,0.1133
		c0.085,0.17,0.1983,0.34,0.3117,0.51c0.0567,0.085,0.085,0.1417,0.1417,0.2267c0,0.0283,0.0283,0.0567,0.0567,0.085l-0.6517,0.68
		c-0.51,0-0.7934,0-1.2184,0.3117l0,0l-2.2385,2.2668c-0.1133,0.085-0.2267,0.1983-0.34,0.3117
		c-0.1417,0.1133-0.255,0.255-0.3967,0.3967c-0.1417,0.1417-0.2834,0.2834-0.425,0.4534c-0.1133,0.1133-0.2267,0.2834-0.2834,0.425
		c-0.255,0.595-0.1417,1.2751,0.3117,1.7568c0.4817,0.4817,1.1617,0.6517,1.7851,0.3967c0.1983-0.0567,0.34-0.17,0.51-0.3117
		c0.1133-0.1133,0.2267-0.2267,0.34-0.34l2.2668-2.2668c0.17-0.17,0.34-0.34,0.51-0.51c0.1417-0.1133,0.255-0.255,0.34-0.3967
		c0.1983-0.3117,0.2267-0.6517,0.255-1.0201c0-0.1133,0.0567-0.1133,0.1133-0.1983c0.085-0.0567,0.1417-0.1133,0.1983-0.17
		s0.1133-0.1417,0.17-0.1983C6.9907,12.1706,7.0474,12.0856,7.104,12.0572z M6.509,11.5755l-0.34,0.3684l-0.3684-0.3684
		c0.0567-0.0567,0.1133-0.1133,0.17-0.17c0.0283-0.0567,0.1133-0.1417,0.1983-0.1983L6.509,11.5755z M5.0639,12.0572
		c0.3117,0.085,0.51,0.255,0.595,0.5667c0.085,0.1983,0.085,0.3967,0,0.595c-0.085,0.255-0.34,0.4534-0.5384,0.6517
		c-0.085,0.085-0.1983,0.1983-0.2834,0.2834l-1.9268,1.9268c0,0-0.0283,0.0283-0.0567,0.0567
		c-0.1417,0.17-0.3117,0.34-0.4817,0.4817c-0.1417,0.1417-0.3117,0.255-0.4817,0.3117c-0.17,0.0567-0.34,0.0567-0.51,0
		c-0.2834-0.085-0.4817-0.2834-0.595-0.5384c-0.1133-0.34-0.0283-0.68,0.1983-0.9067c0.425-0.4534,0.8784-0.8501,1.2751-1.2751
		c0.425-0.425,0.8501-0.8501,1.2751-1.2751c0.0567-0.0567,0.1133-0.1133,0.17-0.1983c0.255-0.2267,0.5384-0.595,0.8784-0.68
		C4.7522,12.0006,4.8939,12.0006,5.0639,12.0572z M11.6943,0.7799c0.68,0.085,1.3601,0.255,1.9835,0.5667
		c0.5384,0.255,1.0201,0.595,1.4451,1.0201C15.2645,2.5083,15.4346,2.65,15.5762,2.82c0.4817,0.5384,0.8501,1.2184,1.0767,1.9268
		c0.2833,0.7934,0.3967,1.6718,0.3117,2.5218c-0.17,1.6151-0.9634,3.0885-2.2385,4.0803c-1.2184,0.9351-2.7485,1.3601-4.2786,1.2184
		c-0.7934-0.0567-1.5868-0.3117-2.2951-0.7367C7.189,11.2922,6.3673,10.4705,5.829,9.4787C5.5739,8.997,5.3756,8.4587,5.2623,7.892
		c-0.1417-0.595-0.17-1.2184-0.1133-1.8134c0.085-0.7934,0.34-1.5868,0.7367-2.2951c0.3117-0.595,0.765-1.1617,1.3034-1.5868
		c0.1417-0.1133,0.2834-0.255,0.4534-0.3684c0.1983-0.1417,0.3967-0.2834,0.6234-0.3967c0.255-0.1417,0.51-0.255,0.7934-0.34
		C9.8809,0.8082,10.8159,0.6665,11.6943,0.7799z M11.5243,1.2899c-1.4734-0.17-2.8902,0.3684-4.0236,1.3034
		C6.594,3.3584,6.0273,4.3784,5.7723,5.5118c-0.17,0.8217-0.17,1.6718,0.0283,2.4935c0.2267,0.8501,0.6234,1.6151,1.1901,2.2385
		c0.425,0.4817,0.9067,0.8784,1.4734,1.1617c0.6517,0.3684,1.3601,0.5667,2.0968,0.6517c2.0968,0.255,4.3353-0.9634,5.2703-2.8335
		c0.7084-1.3601,0.8501-2.8902,0.3684-4.3353c-0.255-0.6517-0.595-1.2751-1.0767-1.7851c-0.425-0.4817-0.9067-0.8784-1.4451-1.1901
		C12.9977,1.5733,12.2894,1.3749,11.5243,1.2899z M11.326,2.0266c0.68,0.0283,1.3034,0.1983,1.8985,0.51
		c0.4817,0.255,0.9067,0.595,1.2751,0.9917c0.3967,0.3967,0.7084,0.9067,0.9067,1.4451c0.255,0.6234,0.3684,1.3034,0.3117,1.9835
		c-0.0283,0.9067-0.3684,1.7851-0.9067,2.4935c-0.4534,0.6234-1.0484,1.1051-1.7284,1.4168
		c-0.7084,0.3684-1.5018,0.51-2.3235,0.4534c-0.425,0-0.8501-0.085-1.2467-0.255c-0.9351-0.3117-1.7568-0.9634-2.3235-1.7851
		C6.594,8.4303,6.3107,7.4386,6.3957,6.3902c0.1133-1.1901,0.595-2.3801,1.5018-3.1735C8.8608,2.395,10.0509,1.9133,11.326,2.0266z
		 M11.0143,2.5367c-0.17,0-0.3684-0.0567-0.5384,0.0567c-0.1417,0.1133-0.1983,0.3117-0.1133,0.4817
		c0.0283,0.0567,0.0567,0.085,0.085,0.1133C10.6176,3.33,10.9009,3.33,11.0993,3.33c0.085,0.0283,0.17,0.0283,0.255,0.0283
		c1.1617,0.1983,2.1251,0.9634,2.6635,2.0118c0.17,0.3967,0.2834,0.765,0.3117,1.1901c0.0283,0.1417,0.0283,0.2834,0.0567,0.425
		c0.0283,0.085,0.0567,0.1983,0.1133,0.255c0.1133,0.085,0.2834,0.1417,0.3967,0.085c0.2267-0.0567,0.2834-0.3117,0.255-0.5384
		c-0.0283-0.9351-0.34-1.8134-0.9067-2.5502C13.4511,3.2167,12.2894,2.65,11.0143,2.5367z"></path>
        </symbol>

        <symbol id="map" viewBox="0 0 16.9727 17.6006">
            <path d="M15.3009,6.5499c0.1417,0,0.5384,0.17,0.68,0.2267v9.4072c-0.1133,0-2.8902-1.0201-3.0035-1.1051v-4.0519
			c0-0.5384-0.085-0.7367,0.17-1.1901c0.3684-0.7367,1.0767-1.7001,1.5868-2.4652C14.9326,7.1166,15.1026,6.8333,15.3009,6.5499z
			 M14.5359,5.8415l-0.0567,0.1417c-0.1133,0.1417-1.8701,2.8618-2.0118,2.9752c-0.17-0.17-2.0685-3.1169-2.1818-3.3152
			C9.9739,5.1048,9.5489,4.3681,9.6339,3.5181c0.2834-2.4652,3.4002-3.3435,4.9303-1.6434c0.7934,0.9067,1.0201,1.8985,0.4817,3.0885
			C14.9326,5.1898,14.6776,5.6999,14.5359,5.8415z M12.1274,2.5547c1.7568-0.4817,2.4085,2.1535,0.7084,2.6068
			C11.1074,5.6149,10.399,3.008,12.1274,2.5547z M12.2408,1.5346C11.4474,1.6479,11.079,1.903,10.7107,2.328
			c-1.3601,1.5584-0.1417,4.0519,2.0401,3.8536c1.1617-0.1133,2.2101-1.2184,2.0685-2.5785
			C14.6776,2.4413,13.5725,1.3079,12.2408,1.5346z M8.9822,16.1838V6.8049c0.1417-0.085,0.51-0.2267,0.68-0.255l1.9268,2.8902
			c0.3684,0.595,0.3967,0.6234,0.3967,1.4168v4.2503C11.8157,15.1921,9.0956,16.1838,8.9822,16.1838z M4.987,5.6999
			c0.17,0.0283,2.7768,0.9917,3.0035,1.1051v9.3789c-0.1133,0-2.8618-0.9917-3.0035-1.0767V5.6999z M0.9917,16.1838
			c-0.0567-1.1051-0.0283-3.4852-0.0283-4.7603l0.0283-4.647l2.9752-1.0767c0.085,0.765,0.0283,6.2337,0.0283,7.5371v1.8418
			C3.8819,15.1638,1.1334,16.1838,0.9917,16.1838z M9.1522,1.9313L9.0956,2.0446C8.8122,2.413,8.6139,3.263,8.6139,3.8581
			c0.0283,0.7367,0.3117,1.1901,0.5384,1.7851H9.1239L8.8972,5.7565c-0.51,0.17-0.34,0.17-0.8784-0.0283L4.5903,4.4814
			c-0.2267-0.0567-1.9835,0.6517-2.3235,0.765C1.9551,5.3598,0.1983,5.9549,0,6.1249v11.4757c0.1417,0,3.7686-1.3601,4.1936-1.5301
			c0.2834-0.085,0.2834-0.1133,0.5384,0l1.5868,0.5667c0.255,0.1133,2.0401,0.7934,2.1535,0.7934s1.8701-0.68,2.1251-0.765
			c0.34-0.1417,0.7084-0.255,1.0767-0.3967c0.6234-0.2267,0.68-0.34,1.0484-0.1983c0.4817,0.17,4.0803,1.5301,4.2503,1.5301V6.0965
			l-1.1617-0.425c0.1133-0.5667,0.9067-1.3884,0.3117-3.0885c-0.3117-0.9351-0.9917-1.6434-1.7284-2.0685
			C12.5524-0.5622,10.2006,0.1178,9.1522,1.9313z"></path>
        </symbol>
        <symbol id="money" viewBox="0 0 17.844 17.8316">
            <path d="M0.758,16.3287h16.321l0.0283,0.7367H0.758V16.3287z M1.438,11.0017
			c-0.0567-0.0567-0.0567-0.0283-0.0567-0.1417l0.34-1.1617C2.5714,9.5566,3.1948,9.16,3.6198,8.4799
			c0.085-0.1133,0.1133-0.2267,0.1983-0.3117c0.3117-0.0283,6.2054,0,6.6587,0c0.255,0,0.5384,0,0.7934,0
			c0.425,0,0.34,0.0567,0.6234,0.2267c0.9917,0.6234,2.2668,0.6517,3.2869,0.1133c0.1983-0.1133,0.34-0.255,0.51-0.34
			c0.085,0.085,0.3684,1.2467,0.425,1.3601c0.0567,0.2834,0.3684,1.2184,0.3684,1.4451c-0.1133,0.0567-0.255,0.0567-0.5667,0.1983
			c-0.2267,0.1133-0.3117,0.2267-0.4534,0.3684c-0.3117,0.2833-0.425,0.5667-0.5667,1.0767H2.9681
			c-0.1417-0.2834-0.085-0.5667-0.51-1.0484C2.2881,11.3984,1.778,11.0017,1.438,11.0017z M3.7615,10.1517
			c0.1133,0.3967,0.8784,0.255,0.7084-0.255C4.2998,9.4716,3.5915,9.6417,3.7615,10.1517z M13.3954,10.1233
			c0.1133,0.425,0.8217,0.3117,0.7367-0.1983C14.0188,9.4716,13.2537,9.6133,13.3954,10.1233z M13.0837,7.2898
			c-0.0283,0.255,0.0283,0.4534,0.2834,0.4817c0.3117,0.0567,0.3967-0.1417,0.4534-0.3684c0.51-0.1133,1.1334-0.595,0.9917-1.2467
			c-0.17-0.6234-0.8501-0.8217-1.2184-1.0767c-0.34-0.2267-0.1417-0.5667,0.1417-0.595c0.5384,0,0.5384,0.34,0.7084,0.4534
			c0.255,0.1983,0.68-0.085,0.5384-0.4534c-0.085-0.2267-0.3967-0.4817-0.5667-0.5667c0.0283-0.7084-0.595-0.595-0.7084-0.3117
			c-0.0567,0.1417,0.0283,0.1417-0.1417,0.1983c-0.085,0.0283-0.17,0.0567-0.255,0.085c-0.8784,0.425-0.9634,1.3884,0.2267,2.0118
			c0.17,0.085,0.3117,0.1417,0.4534,0.255c0.34,0.3117-0.3117,0.9351-1.0484,0.1133c-0.3684-0.3967-1.1334,0.085-0.3117,0.7084
			C12.772,7.1198,12.9137,7.1765,13.0837,7.2898z M9.3718,5.1647c0.5384-0.1133,1.1334-0.6234,0.9634-1.2467
			S9.5135,3.0962,9.1168,2.8412c-0.34-0.2267-0.1133-0.595,0.1983-0.5667c0.5667,0.0283,0.3967,0.3117,0.68,0.4534
			c0.51,0.255,0.9351-0.5384-0.0567-1.0484c0.0283-0.2834-0.0283-0.4817-0.3117-0.51s-0.34,0.17-0.425,0.3684
			C8.6635,1.6795,7.9834,2.1612,8.2668,2.8979c0.255,0.68,1.1334,0.7934,1.3034,1.1051c0.1133,0.1417,0,0.6234-0.6234,0.3684
			c-0.4534-0.17-0.4534-0.4534-0.7084-0.4817C7.8134,3.833,7.7001,4.258,7.9267,4.5413C8.0684,4.683,8.3801,4.938,8.6068,5.023
			c0,0.2834,0.0567,0.51,0.34,0.5384C9.2018,5.5897,9.3152,5.3914,9.3718,5.1647z M11.1853,10.35
			c-0.3684,1.2467-4.8736,0.9917-4.5053-0.255c0.255-0.8501,2.7202-0.9634,3.7686-0.5667C10.7602,9.67,11.2986,9.925,11.1853,10.35z
			 M5.9149,10.35c0.1417,1.0484,1.8985,1.5868,3.1452,1.5584c2.6635-0.085,3.9952-1.9551,1.7568-2.9468
			C8.7768,8.0266,5.7449,8.9333,5.9149,10.35z M0.758,14.8553h16.3493v0.7367H0.758V14.8553z M17.079,14.0903
			c-0.0567,0.0283-0.0567,0.0283-0.2267,0.0283c-0.085,0-0.17,0-0.255,0H2.7981c-0.34,0-1.8418,0.0283-2.0401-0.0283v-0.7084
			c0.17-0.0567,3.5419-0.0283,4.0519-0.0283h8.1888c0.68,0,1.3601,0,2.0401,0c0.3684,0,1.8701-0.0283,2.0685,0
			c0,0.1417,0,0.255,0,0.3684L17.079,14.0903z M16.7106,11.6818c0.0567,0.1983,0.255,0.7934,0.255,0.9351h-1.3034
			C15.6905,12.2201,16.2573,11.6818,16.7106,11.6818z M1.1547,11.6818c0.425,0,1.0484,0.5384,1.0484,0.9351H0.8996L1.1547,11.6818z
			 M1.948,8.8766l0.1983-0.7084h0.2834h0.34h0.17C2.8548,8.3949,2.3164,8.8766,1.948,8.8766z M16.2006,5.8731
			c-0.1133,0.7367-0.3684,1.2467-0.8784,1.7001c-0.765,0.68-2.0401,0.765-2.9752,0.255c-0.1983-0.1133-0.5667-0.425-0.7084-0.595
			c-0.9351-1.0767-0.7367-2.7768,0.3117-3.6836c0.085-0.0567,0.1133-0.085,0.1983-0.1417c0.595-0.34,1.0484-0.51,1.8134-0.425
			C15.2939,3.1529,16.4556,4.3147,16.2006,5.8731z M10.3069,5.6747C8.0117,6.7798,5.6883,4.258,6.935,2.0479
			c0.9067-1.5868,2.9752-1.7001,4.1086-0.5384c0.255,0.255,0.6517,0.8501,0.68,1.3601C10.7602,3.5779,10.3352,4.428,10.3069,5.6747z
			 M12.4037,2.4729c-0.2833-1.1334-1.4451-2.2385-2.6635-2.4368C8.1534-0.1906,6.8783,0.6878,6.3116,1.6512
			c-1.0767,1.7851-0.17,4.2503,1.8985,4.8453c0.9351,0.2834,1.4168,0.1417,2.2101-0.0567c0.1983,0.6234,0.3117,0.6234,0.4534,0.9634
			c-0.5667,0.0567-1.3317,0.0283-1.9268,0.0283H3.1664c-0.34,0-0.6517,0-0.9917,0c-0.3684,0-0.5667-0.0567-0.68,0.2834l-1.4734,5.242
			c-0.0283,0.425,0,2.3801,0,2.9185c-0.0283,2.0685-0.17,1.9551,0.9351,1.9551H17.334c0.34,0,0.51-0.1133,0.51-0.4534
			c0-0.3117,0-0.6234,0-0.9634v-2.8902c0-0.17,0-0.3117,0-0.4817s-0.4534-1.7001-0.51-1.8701
			c-0.34-1.1334-0.6234-2.3518-0.9634-3.4002c-0.0567-0.1983-0.085-0.2267,0.0283-0.3684c1.0767-1.4734,0.5667-3.5419-0.9634-4.6186
			c-0.6517-0.4534-1.4734-0.6234-2.2951-0.51C12.857,2.3312,12.6304,2.4445,12.4037,2.4729z"></path>
        </symbol>
    </svg>
</div>

<div class="pdf-container">
    <header class="hdr">
        <div class="hdr__top">
            <div class="wrapper">
                <img src="http://<?php echo $baseUrl; ?>/pdf-pages/pdf-img/logo.svg" alt="">
            </div>
        </div>
        <div class="hdr__bot">
            <div class="wrapper">
                <p>Отчет о кредитной нагрузке</p>
            </div>
        </div>
    </header></div>



<div class="top-info">
    <div class="wrapper">
        <div class="top-info__cols">
            <div class="top-info__col top-info__col--lg">
                <div class="top-info__col-inner">
                    <h4>ФИО</h4>
                    <p><?php echo $report->name_last; ?> <?php echo $report->name_first; ?> <?php echo $report->name_middle; ?></p>
                </div>
            </div>
            <div class="top-info__col top-info__col--md">
                <div class="top-info__col-inner">
                    <h4>Дата рождения</h4>
                    <p><?php echo $report->birthday; ?></p>
                </div>
            </div>
            <div class="top-info__col top-info__col--sm top-info__col--ta-right">
                <div class="top-info__col-inner">
                    <h4>Дата отчета</h4>
                    <p><?php echo date('d.m.Y',$report->report_date); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(isset($model->status) AND $model->status=='DONE'){?>
    <?php /* @var $report \app\models\ScreeningReport */?>
    <?php if(isset($model->data->unicom->result) AND $model->data->unicom->result==1){?>
        <section class="wrapper">
            <div class="panel padd-wrapper">
                <h3 class="panel-title">1. Кредитный рейтинг</h3>

                <div class="panel__cols">
                    <div class="panel__col panel__col--29">
                        <div class="credit-rating credit-rating--valid">
                            <div class="credit-rating__heading-content">
                                <p class="credit-rating__numb"><?php echo $model->data->unicom->rating->limit; ?></p>
                            </div>
                            <p class="credit-rating__desc">
                                Кредитный рейтинг<br>
                                <span class="credit-rating__status-color">выше среднего</span>
                            </p>
                        </div>
                    </div>
                    <div class="panel__col panel__col--71">

                        <div class="credit-rating credit-rating--valid">
                            <div class="credit-rating__heading-content">

                                <div class="rating-chart rating-chart--positive">
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 10%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                        </div>
                                        <div class="rating-chart__column-name">&lt;100</div>
                                    </div>
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 20%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                        </div>
                                        <div class="rating-chart__column-name">100</div>
                                    </div>
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 27%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                        </div>
                                        <div class="rating-chart__column-name">200</div>
                                    </div>
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 40%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                        </div>
                                        <div class="rating-chart__column-name">300</div>
                                    </div>
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 56%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                        </div>
                                        <div class="rating-chart__column-name">400</div>
                                    </div>
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 79%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                        </div>
                                        <div class="rating-chart__column-name">500</div>
                                    </div>
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 100%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                        </div>
                                        <div class="rating-chart__column-name">600</div>
                                    </div>
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 68%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                            <span class="rating-chart__pointer"></span>
                                        </div>
                                        <div class="rating-chart__column-name">700</div>
                                    </div>
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 42%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                        </div>
                                        <div class="rating-chart__column-name">800</div>
                                    </div>
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 19%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                        </div>
                                        <div class="rating-chart__column-name">900</div>
                                    </div>
                                    <div class="rating-chart__column">
                                        <div class="rating-chart__column-filled-part" style="height: 8%">
                                            <div class="rating-chart__column-filled-part-bg"></div>
                                        </div>
                                        <div class="rating-chart__column-name">1000</div>
                                    </div>
                                </div>
                            </div>
                            <p class="credit-rating__desc">
                                850 - 1000 баллов<br>
                                <span class="credit-rating__status-color">Очень хорошая оценка</span>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <div class="note-wr wrapper">
            <div class="padd-wrapper">
                <div class="note">
                    <div class="note__txt">
                        <p>
                            <?php echo $report->name_last; ?> <?php echo $report->name_first; ?> <?php echo $report->name_middle; ?> практически <span class="h-c-red">не имеет возможности</span> получения новых кредитов в банках, но остается
                            шанс получения кредита в организациях микрофинансирования.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <section class="wrapper">
            <div class="panel padd-wrapper">
                <h3 class="panel-title">2. Состояние кредитов</h3>

                <div class="panel__cols">
                    <div class="panel__col panel__col--25">
                        <div class="state-check">
                            <div class="state-check__ico-wr">
                                <div class="circle-progress circle-progress--green circle-progress--100perc">
                                    <svg class="circle-progress__path" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <svg class="circle-progress__progress" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <span class="circle-progress__txt"><?php echo $model->data->unicom->rating->delay; ?></span>
                                </div>
                            </div>
                            <div class="state-check__txt">
                                <p>В настоящее время <br>
                                    кредитов просрочено</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel__col panel__col--25">
                        <div class="state-check">
                            <div class="state-check__ico-wr">
                                <div class="circle-progress circle-progress--green circle-progress--100perc">
                                    <svg class="circle-progress__path" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <svg class="circle-progress__progress" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <span class="circle-progress__txt"><?php echo $model->data->unicom->rating->max_delay; ?></span>
                                </div>
                            </div>
                            <div class="state-check__txt">
                                <p>Максимальная глубина<br>
                                    просрочки (дней)</p>
                            </div>
                        </div>
                    </div>

                    <div class="panel__col panel__col--25">

                    </div>

                    <div class="panel__col panel__col--25">
                        <div class="state-check">
                            <div class="state-check__ico-wr">
                                <img src="http://<?php echo $baseUrl; ?>/pdf-pages/pdf-img/feather.svg" alt="" style="width: 5.1875rem;">
                            </div>
                            <div class="state-check__txt">
                                <p>Кредитная нагрузка<br>
                                    <span class="h-c-green">отсутсвует</span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <div class="note-wr wrapper">
            <div class="padd-wrapper">
                <div class="note">
                    <div class="note__txt">
                        <p>
                            <?php echo $report->name_last; ?> <?php echo $report->name_first; ?> <?php echo $report->name_middle; ?> практически <span class="h-c-red">не имеет возможности</span> получения новых кредитов в банках, но остается
                            шанс получения кредита в организациях микрофинансирования.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <section class="wrapper">
            <div class="panel padd-wrapper">
                <h3 class="panel-title">3. История кредитов</h3>

                <div class="panel__cols">
                    <div class="panel__col panel__col--25">
                        <div class="state-check">
                            <div class="state-check__ico-wr">
                                <div class="circle-progress circle-progress--orange circle-progress--33perc">
                                    <svg class="circle-progress__path" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <svg class="circle-progress__progress" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <span class="circle-progress__txt"><?php echo $model->data->unicom->rating->total-$model->data->unicom->rating->count; ?></span>
                                </div>
                            </div>
                            <div class="state-check__txt">
                                <p>Выплаченных <br>
                                    (закрытых) кредитов</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel__col panel__col--25">
                        <div class="state-check">
                            <div class="state-check__ico-wr">
                                <div class="circle-progress">
                                    <svg class="circle-progress__path" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <svg class="circle-progress__progress" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <span class="circle-progress__txt"><?php echo $model->data->unicom->rating->inmonth; ?></span>
                                </div>
                            </div>
                            <div class="state-check__txt">
                                <p>Новых кредитов за <br>
                                    последний месяц</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel__col panel__col--25">
                        <div class="state-check">
                            <div class="state-check__ico-wr">
                                <div class="circle-progress circle-progress--green-l circle-progress--25perc">
                                    <svg class="circle-progress__path" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <svg class="circle-progress__progress" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <span class="circle-progress__txt">15%</span>
                                </div>
                            </div>
                            <div class="state-check__txt">
                                <p>Доля платежей<br>
                                    по кредитам</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel__col panel__col--25">
                        <div class="state-check">
                            <div class="state-check__ico-wr">
                                <div class="circle-progress circle-progress--red circle-progress--75perc">
                                    <svg class="circle-progress__path" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <svg class="circle-progress__progress" viewBox="0 0 57.8391 57.839" >
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#prog-circle"></use>
                                    </svg>
                                    <span class="circle-progress__txt">85%</span>
                                </div>
                            </div>
                            <div class="state-check__txt">
                                <p>Остаток на прочие<br>
                                    расходы</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <div class="note-wr wrapper">
            <div class="padd-wrapper">
                <div class="note">
                    <div class="note__txt">
                        <p>
                            <?php echo $report->name_last; ?> <?php echo $report->name_first; ?> <?php echo $report->name_middle; ?> практически <span class="h-c-red">не имеет возможности</span> получения новых кредитов в банках, но остается
                            шанс получения кредита в организациях микрофинансирования.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php }else{ ?>
    <section class="wrapper"><p>По клиенту не найдено данных</p></section><br> <br>
    <?php } ?>
<?php }else{ ?>
    <section class="wrapper"><p>Идет проверка...</p></section><br> <br>
<?php } ?>

<!-- / blocks for other page end -->


<footer class="ftr">
    <div class="wrapper">
        <div class="ftr__inner">
            <div class="ftr__logo-col">
                <img src="http://<?php echo $baseUrl; ?>/pdf-pages/pdf-img/logo-grey.svg" alt="">
            </div>
            <div class="ftr__txt-col">
                <p>
                    Вся представленная на сайте информация, касающаяся характеристик продуктов, наличия на складе, стоимости товаров, носит информационный характер и ни при каких условиях
                    не является публичной офертой, определяемой положениями Статьи 437(2) Гражданского кодекса Российской Федерации. Для получения подробной информации о наличии и
                    стоимости указанных товаров и (или) услуг, пожалуйста, обращайтесь к менеджеру сайта с помощью специальной формы связи или по телефону в Екатеринбурге +7 (343) 270 91 91.
                </p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>