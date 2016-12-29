<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">

</head>
<body>
<div class="page">
    <header class="bar bar-nav">
        <a class="button button-link button-nav pull-left" href="#" data-transition='slide-out'>
            <span class="icon icon-left"></span>
            返回
        </a>
        <h1 class="title">微购</h1>
    </header>

    <nav class="bar bar-tab">
        <a class="tab-item active" href="#">
            <span class="icon icon-home"></span>
            <span class="tab-label">首页</span>
        </a>
        <a class="tab-item" href="/index/member.html">
            <span class="icon icon-me"></span>
            <span class="tab-label">我</span>
        </a>
        <a class="tab-item" href="#">
            <span class="icon icon-star"></span>
            <span class="tab-label">收藏</span>
        </a>
        <a class="tab-item" href="#">
            <span class="icon icon-settings"></span>
            <span class="tab-label">设置</span>
        </a>
    </nav>
    <div class="content">

        <?php foreach($arr as $item=>$value): ?>
        <div class="card demo-card-header-pic">
            <div valign="bottom" class="card-header color-white no-border no-padding">
                <img class='card-cover' src="//gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q61.jpg" alt="">
            </div>
            <div class="card-content">
                <div class="card-content-inner">
                    <p class="color-gray"><?php echo $value; ?></p>
                    <div>
                        <span>$20.00</span>
                        <span style="float: right">$20.00</span>
                    </div>

                </div>
            </div>
            <div class="card-footer no-border">
                <a href="#" class="link">赞</a>
                <a href="#" class="link">评论</a>
                <a href="#" class="link">分享</a>
            </div>
        </div>

        <?php endforeach; ?>

    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>

</body>
</html>