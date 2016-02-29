<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo</title>
    <link href="<?php echo SRC_STYLESHEET ?>bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">MVC</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#view">View <span class="sr-only">(current)</span></a></li>
                    <li><a href="#model">Model</a></li>
                    <li><a href="#controller">Controller</a></li>
                </ul>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="jumbotron">
        <h1>Hello, world!</h1>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
    </div>

    <div id="view">
        <h1>View</h1>
        <table class="table table-hover">
            <tr>
                <th width="400px">函数名</th>
                <th width="300px">示例</th>
                <th>说明</th>
            </tr>
            <tr>
                <td>$this->response->setOutput();</td>
                <td>$this->response->setOutput('要输出内容');</td>
                <td>设置输出内容，注意此处并不输出</td>
            </tr>
            <tr>
                <td>$this->render($template_file);</td>
                <td>$this->render('index');</td>
                <td>渲染模板，$template_file为模板的路径，请用“文件夹/名称”格式。php文件可不带后缀</td>
            </tr>
            <tr>
                <td>$response->output();</td>
                <td>$response->output();</td>
                <td>输出模板，初始化就会输出，不必手动输出</td>
            </tr>
        </table>
    </div>
    <div id="model">
        <h1>Model</h1>
        <table class="table table-hover">
            <tr>
                <th width="400px">函数名</th>
                <th width="300px">示例</th>
                <th>说明</th>
            </tr>
            <tr>
                <td>$this->load->model($model_file,$model_name);</td>
                <td>$this->load->model('test');</td>
                <td>加载model,$model_file为model文件名，
                    $model_name为别名，默认为$model_file＋_model如文件包含文件夹，
                    请用“文件夹/名称”格式
                </td>
            </tr>
            <tr>
                <td>$this->$model_name->function();</td>
                <td>$this->test_model->test();</td>
                <td>执行model方法</td>
            </tr>
        </table>
    </div>
    <div id="controller">
        <h1>Controller</h1>
        <table class="table table-hover">
            <tr>
                <th width="400px">函数名</th>
                <th width="300px">示例</th>
                <th>说明</th>
            </tr>
        </table>
    </div>
</div>
<script src="<?php echo SRC_JAVASCRIPT ?>jquery-1.11.1.min.js"></script>
<script src="<?php echo SRC_JAVASCRIPT ?>bootstrap.min.js"></script>
</body>
</html>