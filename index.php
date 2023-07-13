<!DOCTYPE html>
<html>
<head>
    <title>React Code Builder</title>
    <link rel="stylesheet" href="index.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
</head>

<body>
    <h1>React Code Builder</h1>
    <?php
    include 'general.php';    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $componentName = isset($_POST['componentName']) ? trim($_POST['componentName']) : '';
        $parameters = isset($_POST['parameters']) ? trim($_POST['parameters']) : '';

        if ($componentName === '' || $parameters === '') {
            echo '<div class="error">Please provide both the component name and parameters.</div>';
        } else {
            echo '<div class="code-container"><span class="my-heading">'.ucfirst($componentName).'Create Code</span>
            <i  onclick="copyCode(this)" class="fa fa-clipboard copy-icon" style="font-size:30px;"></i><span class="copy-message"  style="opacity: 0;">Code copied!</span>';
            echo generateComponentCreateCode($componentName, $parameters).'</div>';
            
            echo '<div class="code-container"><span class="my-heading">'.ucfirst($componentName).'List Code:</span>
            <i  onclick="copyCode(this)" class="fa fa-clipboard copy-icon" style="font-size:30px;"></i>
            <span class="copy-message"  style="opacity: 0;">Code copied!</span>';
            echo generateBookListCode($componentName).'</div>';

            echo '<div class="code-container"><span class="my-heading">'.ucfirst($componentName).'Show Code:</span>
            <i  onclick="copyCode(this)" class="fa fa-clipboard copy-icon" style="font-size:30px;"></i><span class="copy-message"  style="opacity: 0;">Code copied!</span>';
            echo generateComponentShowCode($componentName, $parameters).'</div>';

            echo '<div class="code-container"><span class="my-heading">'.ucfirst($componentName).'Edit Code:</span>
            <i  onclick="copyCode(this)" class="fa fa-clipboard copy-icon" style="font-size:30px;">
            </i><span class="copy-message"  style="opacity: 0;">Code copied!</span>';
            echo generateComponentEditCode($componentName, $parameters).'</div>';

            echo '<div class="code-container"><span class="my-heading">'.ucfirst($componentName).'Application Code:</span>
            <i  onclick="copyCode(this)" class="fa fa-clipboard copy-icon" style="font-size:30px;">
            </i><span class="copy-message"  style="opacity: 0;">Code copied!</span>';
            echo generateApplicationCode($componentName, $parameters).'</div>';
        }
    }
    ?>

    <form method="POST">
        <label>Component Name</label>
        <input type="text" name="componentName" required>

        <label>Parameters (comma-separated)</label>
        <input type="text" name="parameters" required>

        <button type="submit">Generate Code</button>
    </form>
</body>
<script src="index.js"></script>
</html>