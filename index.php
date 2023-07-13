<!DOCTYPE html>
<html>
<head>
    <title>React Code Builder</title>
    <link rel="stylesheet" href="index.css">  
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
            echo '<h3>'.ucfirst($componentName).'Create Code</h3>';
            generateComponentCreateCode($componentName, $parameters);
            
            echo '<h3>'.ucfirst($componentName).'List Code:</h3>';
            echo generateBookListCode($componentName);

            echo '<h3>'.ucfirst($componentName).'Show Code:</h3>';
            echo generateComponentShowCode($componentName, $parameters);

            echo '<h3>'.ucfirst($componentName).'Edit Code:</h3>';
            echo generateComponentEditCode($componentName, $parameters);

            echo '<h3>'.ucfirst($componentName).'Application Code:</h3>';
            echo generateApplicationCode($componentName, $parameters);
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
</html>