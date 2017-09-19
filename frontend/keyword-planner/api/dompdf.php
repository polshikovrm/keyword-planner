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
                color: #808080;
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
                margin: 0 0 126px;
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
                margin: 0 0 56px;
            }

            .content-holder .table.result-table th {
                font-size: 32px;
                border: 2px solid #f3f3f3;
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
            }

            .content-holder .table .select-holder {
                text-align: left;
                vertical-align: middle;
            }

            .content-holder .table .select-holder .select-button {
                background: #e6e6e6;
                border-color: #c8c8c8;
                margin: 0 0 0 15px;
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
                padding: 18px 88px 20px 20px;
                margin: 0 40px;
                cursor: pointer;
            }

            .select-holder .select-button:after {
                content: "";
                background: url(../assets/sprite.png) no-repeat -85px -176px;
                width: 25px;
                height: 13px;
                position: absolute;
                top: 50%;
                right: 20px;
                transform: translate(0, -50%);
            }

            .select-holder.open .select-button:after {
                background-position: -85px -206px;
            }

            .select-holder .select-list {
                position: absolute;
                margin: 0;
                padding: 0;
                list-style: none;
                font-size: 25px;
                background: #f2f2f2;
                border: 1px solid #ededed;
                top: 100%;
                left: 40px;
                right: 40px;
                max-height: 0;
                opacity: 0;
                transform: translate(0, -100%;
            ) transition: all 0.3 s ease-out;
            }

            .select-holder.open .select-list {
                max-height: 4000px;
                opacity: 1;
                transform: translate(0, 0;
            )
            }

            .select-holder .select-list li {
                padding: 10px 20px;
                cursor: pointer;
                transition: all 0.3s ease-out;
            }

            .select-holder .select-list li:hover {
                background: #fcce01;
                color: #fff;
            }

            .loading {
                display: block;
                margin: 0 auto;
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
                    padding: 14px 70px 15px 15px;
                }

                .content-holder .table .select-holder .select-button {
                    padding: 10px 50px 10px 10px;
                    font-size: 18px;
                }

                .select-holder .select-list {
                    font-size: 22px;
                }

                .content-holder .table .select-holder .select-list {
                    font-size: 16px;
                }

                .content-holder .table .select-holder .select-list li {
                    padding: 5px 10px;
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

            @media only screen and (max-width: 992px) {

                .select-holder .select-button {
                    text-align: left;
                }

                .select-holder .select-list {
                    text-align: left;
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
                    padding: 6px 43px 7px 10px;
                    text-align: left;
                }

                .content-holder .table .select-holder .select-button:after,
                .select-holder .select-button:after {
                    background-position: -93px -110px;
                    width: 17px;
                    height: 10px;
                    right: 10px;
                }

                .content-holder .table .select-holder.open .select-button:after,
                .select-holder.open .select-button:after {
                    background-position: -93px -142px;
                }

                .content-holder .table .select-holder .select-list,
                .select-holder .select-list {
                    left: 10px;
                    right: 10px;
                    text-align: left;
                    font-size: 14px;
                }

                .content-holder .table .select-holder .select-list li,
                .select-holder .select-list li {
                    padding: 7px 5px;
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
                <div>
                    <table class="table result-table results-list">
                        <thead>
                        <tr>
                            <th><span class="title">Locations</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Kiev,Kyiv city,Ukraine -City</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table result-table">
                        <thead>
                        <tr>
                            <th class="width1">Your Selected Keywords</th>
                            <th class="width2"><span class="text">Average searches</span> <span class="select-holder"><button
                                        type="button" class="select-button">Month</button></span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="width1">tattoo</td>
                            <td class="width2">1,000</td>
                        </tr>
                        <tr>
                            <td class="width1">body</td>
                            <td class="width2">390</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table result-table">
                        <thead>
                        <tr>
                            <th class="width1">More Suggested Keywords</th>
                            <th class="width2"><span class="text">Average searches</span> <span class="select-holder"><button
                                        type="button" class="select-button">Month</button> </span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="width1">bodys</td>
                            <td class="width2">10</td>
                        </tr>
                        <tr>
                            <td class="width1">tattoo designs</td>
                            <td class="width2">50</td>
                        </tr>
                        <tr>
                            <td class="width1">tato</td>
                            <td class="width2">40</td>
                        </tr>
                        <tr>
                            <td class="width1">bodies</td>
                            <td class="width2">30</td>
                        </tr>
                        <tr>
                            <td class="width1">tattoos for men</td>
                            <td class="width2">50</td>
                        </tr>
                        <tr>
                            <td class="width1">tattoo shops</td>
                            <td class="width2">50</td>
                        </tr>
                        <tr>
                            <td class="width1">tattoo designs for men</td>
                            <td class="width2">10</td>
                        </tr>
                        <tr>
                            <td class="width1">tattoos for women</td>
                            <td class="width2">10</td>
                        </tr>
                        <tr>
                            <td class="width1">tribal tattoo</td>
                            <td class="width2">50</td>
                        </tr>
                        <tr>
                            <td class="width1">sleeve tattoos</td>
                            <td class="width2">40</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php
$html = ob_get_clean();
$options = new Options();
$options->set('defaultFont', 'Times-Italic');
// instantiate and use the dompdf class
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();



