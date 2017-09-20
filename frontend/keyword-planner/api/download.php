<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// include autoloader
require __DIR__ . '/../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
ob_start();
?>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,maximum-scale=1.0">
        <title>keyword-planner</title>
        <style>
            }
            * {
                max-height: 10000px;
            }

            html {
                box-sizing: border-box;
            }

            *, *:before, *:after {
                box-sizing: inherit;
            }

            body {
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: none;
                margin: 0;
                min-width: 320px;
                font: 20px/1 "Times-Italic", Arial, Helvetica, sans-serif;
                color: #666;
                background: #fff;
            }

            article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {
                display: block;
            }

            figure {
                margin: 0;
                padding: 0;
            }

            img {
                vertical-align: top;
                max-width: 100%;
                border: 0;
            }

            a {
                color: #000;
                text-decoration: none;
                outline: none;
            }

            a:hover {
                text-decoration: underline;
            }

            button::-moz-focus-inner {
                padding: 0;
                border: 0;
            }

            form,
            fieldset {
                margin: 0;
                padding: 0;
                border: 0;
            }

            input,
            textarea,
            select {
                font: 12px Arial, Helvetica, sans-serif;
                vertical-align: middle;
                outline: none;
            }

            :active, :hover, :focus {
                outline: 0;
                outline-offset: 0;
            }

            :-moz-placeholder {
                color: #666;
            }

            ::-webkit-input-placeholder {
                color: #666;
            }

            :-ms-input-placeholder {
                color: #666;

            }

            ::-moz-placeholder {
                color: #666;
                opacity: 1;
            }

            input[type="image"] {
                padding: 0;
                border: none;
            }

            input[type=url], input[type=search], input[type=tel], input[type=email], input[type=text], input[type=password], input[type=file], input[type=submit], textarea {
                -webkit-appearance: none;
                background: transparent;
            }

            input[type="search"]::-webkit-search-cancel-button {
                -webkit-appearance: none;
            }

            input:-webkit-autofill {
                background: #fcce01 !important;
                -webkit-box-shadow: 0 0 0 50px #fcce01 inset !important;
                -webkit-text-fill-color: #666;
            }

            input:focus::-moz-placeholder,
            textarea:focus::-moz-placeholder {
                color: transparent;
            }

            input:focus::-webkit-input-placeholder,
            textarea:focus::-webkit-input-placeholder {
                color: transparent;
            }

            input:focus:-ms-input-placeholder,
            textarea:focus:-ms-input-placeholder {
                color: transparent;
            }

            button[type="submit"] {
                cursor: pointer;
            }

            p {
                margin: 0 0 13px;
            }

            .clearfix:after {
                content: "";
                display: block;
                clear: both;
            }

            .btn {
                display: inline-block;
                vertical-align: top;
                color: #fff;
                text-align: center;
                border-radius: 26px;
                background: #ffce00;
                border: 1px solid #ffce00;
                padding: 11px 27px;
                transition: all 0.3s ease-out;
                font: 24px "flamabook", Arial, Helvetica, sans-serif;;
            }

            .btn:hover {
                background: #fff;
                color: #ffce00;
                text-decoration: none;
            }

            .btn.gray {
                background: #515c63;
                border: 1px solid #515c63;
            }

            .btn.gray:hover {
                background: transparent;
                color: #515c63;
                border-color: #515c63;
            }

            .btn:hover .arrow-left {
                background-position: 0 -39px;
            }

            .btn.no-active {
                background: #515c63;
                border: 1px solid #515c63;
                cursor: wait !important;
            }

            .btn.no-active:hover {
                color: #fff;
            }

            .arrow-left {
                background: url(../assets/sprite.png) no-repeat;
                width: 11px;
                height: 24px;
                display: inline-block;
                vertical-align: middle;
            }

            .btn .arrow-left {
                margin: 0 0 0 16px;
            }

            /*----------- targetLocations styles ----------------*/
            .content-holder h1 {
                font: 58px/1 "flamabook", Arial, Helvetica, sans-serif;
                color: #333;
                margin: 0 0 38px;
            }

            .content-holder {
                max-width: 2052px;
                margin: 0 auto;
                padding: 33px 0;
            }

            .title-block {
                padding: 0 0 40px;
            }

            .location-content {
                margin: 0 -26px 15px;
                font-family: "flamabook", Arial, Helvetica, sans-serif;
            }

            .location-holder {
                padding: 0 26px;
                width: 50%;
                float: left;
            }

            .content-holder .results-list {
                padding: 0;
                margin: 0 0 15px;
                list-style: none;
                border: 1px solid #f2f2f2;
                font-size: 33px;
                color: #00b3e3;
            }

            .content-holder .results-list.table .title {
                background: #f2f2f2;
                color: #000;
                font-family: "flamalight", Arial, Helvetica, sans-serif;
                padding: 20px 26px 29px;
            }

            .content-holder .results-list.table li {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                -webkit-box-pack: justify;
                -ms-flex-pack: justify;
                justify-content: space-between;
                border-bottom: 1px solid #f2f2f2;
                padding: 16px 25px 12px;
                color: #00b3e3;
            }

            .content-holder .results-list.table li:last-child {
                border: none;
            }

            .content-holder .results-list.table p {
                margin: 0;
            }

            .content-holder .results-list.table .func {
                display: inline-block;
                vertical-align: top;
                border-right: 1px solid #ccc;
                padding: 0 10px 13px;
                cursor: pointer;
                transition: all 0.3s ease-out;
            }

            .content-holder .results-list.table .func:last-child {
                border: none;
            }

            .content-holder h2 {
                margin: 0 0 20px;
                color: #ffce00;
                font: 44px/1.2 "flamabasic", Arial, Helvetica, sans-serif;
            }

            .calculate-holder h2 {
                margin: 0 0 92px;
            }

            .content-holder .table {
                width: 100%;
                font: 32px/1 "Times-Italic", Arial, Helvetica, sans-serif;
                margin: 0 0 30px;
            }

            .content-holder .table th {
                background: #f2f2f2;
                color: #333;
                text-align: left;
                font-family: "Times-Italic", Arial, Helvetica, sans-serif;
                padding: 40px 36px 49px;
            }

            .content-holder .table th,
            .content-holder .table td {
                border: solid #f2f2f2;
                border-width: 0 0 1px;
                border-collapse: collapse;
            }

            .content-holder .table td {
                padding: 57px 33px 61px;
            }

            .content-holder .table td:last-child {
                text-align: right;
                padding-right: 82px;
            }

            .content-holder .table tfoot td {
                padding-top: 32px;
                padding-bottom: 32px;
                border: none;
            }

            .content-holder .table .total {
                display: inline-block;
                vertical-align: top;
                padding: 0 30px 0 0;
            }

            /*----------------- find keywords page styles ----------*/
            .btn-logout {
                margin: 0 0 10px 10px;
                float: right;
            }

            .gray-bg {
                background: #d7dbdd;
                padding: 10px 0;
            }

            .btn.reset {
                background: #999;
                border-color: #999;
            }

            .btn.reset:hover {
                background: #fff;
                color: #999;
            }

            .btn-next {
                float: right;
            }

            .btn-prev {
                float: left;
            }

            .chart-holder {
                border: 2px solid #f2f2f2;
                padding: 46px 58px 65px;
            }

            .download-block {
                padding: 78px 0 242px;
            }

            .download-block .btn-simple {
                float: right;
            }

            .btn-simple {
                color: #4d4d4d;
                background: #f2f2f2;
                border: 1px solid #ededed;
                font-size: 31px;
                padding: 19px 29px 20px;
                transition: all 0.3s ease-out;
            }

            .btn-simple:hover {
                text-decoration: none;
                background: #4d4d4d;
                border-color: #4d4d4d;
                color: #f2f2f2;
            }

            .btn-simple .icon-download {
                display: inline-block;
                vertical-align: top;
                background: url(../assets/sprite.png) no-repeat 0 -178px;
                width: 23px;
                height: 35px;
                margin: 0 19px 0 0;
            }

            .btn-simple:hover .icon-download {
                background-position: -39px -178px;
            }

            .content-holder .table.result-table {
                border: solid #f3f3f3;
                border-width: 0 2px;
                border-spacing: 0;
                margin: 0 0 30px;
            }

            .content-holder .table.result-table th {
                font-size: 32px;
                border: 2px solid #f3f3f3;
                color: #000;
            }

            .content-holder .table.result-table td:last-child {
                padding-right: 36px;
            }

            .content-holder .table .width1 {
                width: 55%;
            }

            .content-holder .table .width2 {
                width: 45%;
                text-align: right;
            }

            .content-holder .table td.width2 {
                padding-right: 10%;
            }

            .content-holder .table.result-table .text {
                display: inline-block;
                vertical-align: middle;
                color: #000;
            }

            .content-holder .table .select-holder {
                text-align: center;
                vertical-align: middle;
            }

            .content-holder .table .select-holder .select-button {
                background: #e6e6e6;
                border-color: #c8c8c8;
                margin: 0 0 0 15px;
                text-align: center;
            }

            .content-holder .table .select-holder .select-list {
                background: #e6e6e6;
                border-color: #c8c8c8;
                left: 15px;
                right: 0;
            }

            .add-btn {
                display: block;
                width: 51px;
                height: 51px;
                border: 2px solid #ffce00;
                border-radius: 50%;
                text-align: center;
                background: #fff;
                color: #ffce00;
                font: 42px/40px "flamabasic", Arial, Helvetica, sans-serif;
                margin: 0 auto;
                transition: all 0.3s ease-out;
                cursor: pointer;
                position: relative;
            }

            .add-btn:hover {
                background: #ffce00;
                color: #fff;
                text-decoration: none;
            }

            .add-btn.plus {
                background: #ffce00;
                color: transparent;
            }

            .add-btn.plus:before {
                content: "";
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: #fff;
                width: 21px;
                height: 3px;
            }

            .select-holder {
                display: inline-block;
                vertical-align: top;
                position: relative;
                color: #4d4d4d;
            }

            .select-holder .select-button {
                background: #f2f2f2;
                border: 1px solid #ededed;
                color: #4d4d4d;
                font-size: 27px;
                position: relative;
                display: inline-block;
                vertical-align: top;
                padding: 18px 25px 20px;
                margin: 0 40px;
                cursor: pointer;
                text-align: center;
            }

            /*---------- User management page styles --------------*/
            .users-table th,
            .users-table td {
                width: 40%;
                word-break: break-all;
                word-wrap: break-word;
            }

            .users-table th:last-child,
            .users-table td:last-child {
                width: 20%;
            }

            .content-holder .table.users-table td:last-child {
                text-align: center;
                padding-right: 33px;
            }

            @media only screen and (max-width: 2060px) {
                .content-holder {
                    max-width: none;
                    padding: 33px 113px;
                }
            }

            @media only screen and (max-width: 1800px) {
                /*----------- targetLocations styles ----------------*/
                .content-holder {
                    padding: 60px 80px;
                }

                .content-holder h1 {
                    font-size: 37px;
                }

                .location-content {
                    margin: 0 -17px 15px;
                }

                .location-holder {
                    padding: 0 17px;
                }

                .content-holder .results-list.table {
                    font-size: 21px;
                }

                /*----------- RoiCalculator page styles --------------*/
                .content-holder h2 {
                    font-size: 32px;
                }

                .content-holder .table {
                    font-size: 16px;
                    margin: 0 0 30px;
                }

                .content-holder .table th,
                .content-holder .table td {
                    padding: 15px 16px 18px;
                }

                .content-holder .table td:last-child {
                    padding-right: 20px;
                }

                .download-block {
                    padding: 30px 0 70px;
                }

                .content-holder .table.result-table th {
                    font-size: 16px;
                }

                .select-holder .select-button {
                    font-size: 24px;
                    padding: 14px 25px 15px;
                }

                .content-holder .table .select-holder .select-button {
                    padding: 10px 25px 10px;
                    font-size: 18px;
                }

                .content-holder .table td.width2 {
                    padding-right: 4%;
                }

                .content-holder .table.users-table td:last-child {
                    padding-right: 16px;
                }
            }

            @media only screen and (max-width: 1500px) {
                /*----------- targetLocations styles ----------------*/

                .content-holder .results-list.table li {
                    padding: 9px 10px 15px 17px;
                }

                .content-holder .results-list.table .title {
                    padding: 13px 20px 18px;
                }

                .content-holder .results-list.table .func {
                    padding: 0 4px 6px;
                }
            }

            @media only screen and (max-width: 1120px) {
                p {
                    margin: 0 0 7px;
                }

                .btn {
                    font-size: 18px;
                }
                /*----------- targetLocations styles ----------------*/
                .content-holder {
                    padding: 31px 20px;
                }
            }

            @media only screen and (max-width: 1100px) {
                p {
                    margin: 0 0 14px;
                }

            }

            @media only screen and (max-width: 767px) {
                .btn {
                    font-size: 16px;
                }

                /*----------- targetLocations styles ----------------*/
                .title-block {
                    text-align: left;
                    padding: 0;
                }

                .content-holder h1 {
                    font-size: 25px;
                    margin: 0 0 26px;
                }

                .location-content {
                    margin: 0 0 15px;
                }

                .location-holder {
                    float: none;
                    width: 100%;
                    padding: 0 0 10px;
                }

                .content-holder .results-list.table {
                    font-size: 11px;
                }

                .content-holder .results-list.table li {
                    padding: 7px 6px 8px;
                }

                .content-holder .results-list.table .title {
                    padding: 7px 8px 9px;
                }

                .content-holder .results-list.table .func {
                    padding: 0 4px;
                }

                /*----------------- find keywords page styles ----------*/
                .btn-logout {
                    margin: 0 0 20px;
                }

                .gray-bg {
                    padding: 10px 0 0;
                }

                .keyword-form {
                    padding: 26px 0 0;
                }

                .download-block {
                    padding: 10px 0 6px;
                }

                .btn-simple {
                    font-size: 11px;
                    padding: 8px 10px 9px;
                }

                .btn-simple .icon-download {
                    background-position: 0 -235px;
                    width: 10px;
                    height: 15px;
                    margin: -3px 9px 0 0;
                }

                .btn-simple:hover .icon-download {
                    background-position: -23px -235px;
                }

                .add-btn {
                    height: 30px;
                    width: 30px;
                    font-size: 24px;
                    line-height: 24px;
                    border-width: 1px;
                }

                .add-btn.plus:before {
                    width: 15px;
                    height: 2px;
                }

                .content-holder .table th,
                .content-holder .table td {
                    padding: 15px 10px 18px;
                }

                .content-holder .table.result-table td:last-child {
                    padding-right: 10px;
                }

                .content-holder .table td.width2 {
                    padding-right: 10px;
                    text-align: center;
                }

                .select-holder .select-button,
                .content-holder .table .select-holder .select-button {
                    font-size: 16px;
                    margin: 0 10px;
                    padding: 6px 25px 7px;
                    text-align: center;
                }

                /*----------- User management page styles -----------*/
                .users-table .btn {
                    padding: 6px 10px;
                }

                .users-table th,
                .users-table td {
                    width: 33%;
                }

                .users-table th:last-child,
                .users-table td:last-child {
                    padding: 15px 5px;
                    width: 33%;
                }

                .content-holder .table.users-table td:last-child {
                    padding-right: 5px;
                }

                .help {
                    font-size: 10px;
                }

            }

            @media only screen and (max-width: 600px) {
                .content-holder .table.result-table .text {
                    display: block;
                    margin: 0 0 5px;
                }
            }
            .content-holder .results-list th,
            .content-holder .results-list td{
                font-size:18px;
            }
            .content-holder .results-list td{
                color: #00b3e3;
            }
        </style>

    </head>
    <body>
    <div id="app">
        <div class="find-keywords">
            <div class="content-holder">

                <H1>Keyword Demand Data</H1>

                <?php if(isset($_POST['locations'])){ ?>
                <div>
                    <table class="table result-table results-list">
                        <thead>
                        <tr>
                            <th><span class="title">Locations</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php foreach ($_POST['locations'] as $value){ ?>
                                <td><?php echo $value ?></td>
                            <?php } ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
                <div>
                    <table class="table result-table">
                        <thead>
                        <tr>
                            <th class="width1">Your Selected Keywords</th>
                            <th class="width2" style="text-align: right;"><span class="text">Average searches</span> <span class="select-holder"><button
                                        type="button" class="select-button" style="text-align: center;"><?php echo $_POST['queryResultStatsInterval']?></button></span></th>
                        </tr>
                        </thead>
                        <tbody>
                         <?php foreach ($_POST['queryResultStats']['keyword'] as $key=>$value){ ?>
                             <tr>
                                 <td class="width1"><?php echo $value ?></td>
                                 <td class="width2" style="text-align: right; padding-right: 33px;">
                                     <?php
                                     if ($_POST['queryResultStatsInterval'] == 'Month') {
                                         echo (int)$_POST['queryResultStats']['searchVolume'][$key];
                                     } elseif ($_POST['queryResultStatsInterval'] == 'Day') {
                                         echo round($_POST['queryResultStats']['searchVolume'][$key] / 30);
                                     } elseif ($_POST['queryResultStatsInterval'] == 'Year') {
                                         echo round($_POST['queryResultStats']['searchVolume'][$key] * 12);
                                     }
                                     ?></td>
                             </tr>
                         <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table result-table">
                        <thead>
                        <tr>
                            <th class="width1">More Suggested Keywords</th>
                            <th class="width2" style="text-align: right;"><span class="text">Average searches</span> <span class="select-holder"><button
                                        type="button" class="select-button" style="text-align: center;"><?php echo $_POST['queryResultInterval']?></button> </span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($_POST['queryResult']['keyword'] as $key=>$value){ ?>
                            <tr>
                                <td class="width1"><?php echo $value ?></td>
                                <td class="width2"  style="text-align: right; padding-right: 33px;">
                                    <?php
                                    if ($_POST['queryResultInterval'] == 'Month') {
                                        echo $_POST['queryResult']['searchVolume'][$key];
                                    } elseif ($_POST['queryResultInterval'] == 'Day') {
                                        echo round($_POST['queryResult']['searchVolume'][$key] / 30);
                                    } elseif ($_POST['queryResultInterval'] == 'Year') {
                                        echo round($_POST['queryResult']['searchVolume'][$key] * 12);
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
<!--                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASQAAAAnCAYAAACmGjX2AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NEI4MTJEQTk3REFGMTFFN0EwMjFFNDUwNUE2OUZFOUUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NEI4MTJEQUE3REFGMTFFN0EwMjFFNDUwNUE2OUZFOUUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo0QjgxMkRBNzdEQUYxMUU3QTAyMUU0NTA1QTY5RkU5RSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo0QjgxMkRBODdEQUYxMUU3QTAyMUU0NTA1QTY5RkU5RSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Ph1wsi0AABEWSURBVHja7F0J3FZT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" alt="">-->
            </div>
        </div>
    </div>
    </body>
    </html>
<?php
$html = ob_get_clean();
$options = new Options();
//$options->set('defaultFont', 'Times-Italic');
// instantiate and use the dompdf class
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();



