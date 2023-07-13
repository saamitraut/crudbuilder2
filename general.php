<?php
    function generateComponentCreateCode($componentName, $parameters) {
        $componentNamePascal = ucwords($componentName).'Create';
        $componentNameCamel = lcfirst($componentNamePascal);

        $parametersArray = explode(',', $parameters);
        $stateCode = '';
        $setStateCode = '';
        $inputCode = '';
        
        foreach ($parametersArray as $parameter) {
            $parameter = trim($parameter);
            $parameterPascal = ucwords($parameter);
            $stateCode .= "  const [{$parameter}, set{$parameterPascal}] = useState('');\n";
            
                        $inputCode .= <<<HTML
                    <label>{$parameterPascal}</label>
                    <input
                    className="input"
                    type="text"
                    name="{$parameter}"
                    value={{$parameter}}
                    onChange={handleChange}
                    />\n
                    HTML;
        }

        $parameterList = implode(', ', $parametersArray);
        $newBookCode = "  const newBook = {\n    id: Math.round(Math.random() * 9999),\n    {$parameterList}\n  };";

        $stateResetCode = '';
        foreach ($parametersArray as $parameter) {
            $parameter = trim($parameter);
            $parameterPascal = ucwords($parameter);
            
            $setStateCode .= "    if (name === '{$parameter}') {\n";
            $setStateCode .= "      set{$parameterPascal}(value);\n";
            $setStateCode .= "    }\n";
        }

        $outputCode = <<<JS
        import { useState } from 'react';


        function {$componentNamePascal}({ onCreate,toggleModal }) {
        {$stateCode}
        const handleChange = (event) => {
            const { name, value } = event.target;
            {$setStateCode}
        };

        const handleSubmit = (event) => {
            event.preventDefault();
        {$newBookCode}
            onCreate(newBook);
            toggleModal();
        {$stateResetCode}
        };

        return (
            <div className="book-create1">
            <h3>Add a {$componentNamePascal}</h3>
            <form onSubmit={handleSubmit}>
        {$inputCode}
                <button className="button">Create!</button>
            </form>
            </div>
        );
        }

        export default {$componentNamePascal};
        JS;

        echo '<div class="code-snippet">';
        echo '<code>' . htmlspecialchars($outputCode) . '</code>';
        echo '</div>';
    }



    function generateBookListCode($componentName)
    {
      $componentNamePascal = ucwords($componentName).'Show';  
      
      $componentNameList = ucwords($componentName).'List';
      $componentNamePluralCapital = ucwords($componentName).'s';    
      $componentNamePluralSmall = $componentName.'s';    
      $id=$componentName.'.id';
      
      $code = <<<EOD
    import $componentNamePascal from './$componentNamePascal';

    function $componentNameList({ $componentNamePluralSmall, onDelete, onEdit }) {
    const rendered$componentNamePluralCapital = $componentNamePluralSmall.map(($componentName) => {
        return (
        <$componentNamePascal onEdit={onEdit} onDelete={onDelete} key={{$id}} $componentName={{$componentName}} />
        );
    });

    return (
        <div className="$componentName-list">
        {rendered$componentNamePluralCapital}
        </div>
    );
    }

    export default $componentNameList;
    EOD;

        return '<code class="code-snippet">' . htmlspecialchars($code) . '</code>';
    }
    
    function generateComponentShowCode($componentName, $parameters) {
        
        $componentNamePascal = ucwords($componentName).'Show';
    
        $parametersArray = explode(',', $parameters);
        $contentCode = '';
    
        foreach ($parametersArray as $parameter) {
            $parameter = trim($parameter);
            $parameterPascal = ucwords($parameter);
            
            $contentCode .= "      <p>{$parameterPascal}: {book.{$parameter}}</p>\n";
        }
    
        $outputCode = <<<JS
    import { useState } from 'react';
    import BookEdit from './BookEdit';
    
    function {$componentNamePascal}({ book, onDelete, onEdit }) {
      const [showEdit, setShowEdit] = useState(false);
    
      const handleDeleteClick = () => {
        onDelete(book.id);
      };
    
      const handleEditClick = () => {
        setShowEdit(!showEdit);
      };
    
      const handleSubmit = (id, updatedBook) => {
        setShowEdit(false);
        onEdit(id, updatedBook);
      };
    
      let content = (
        <div>
    {$contentCode}    </div>
      );
    
      if (showEdit) {
        content = <BookEdit onSubmit={handleSubmit} book={book} />;
      }
    
      return (
        <div className="book-show">
          <div>{content}</div>
          <div className="actions">
            <button className="edit" onClick={handleEditClick}>
              Edit
            </button>
            <button className="delete" onClick={handleDeleteClick}>
              Delete
            </button>
          </div>
        </div>
      );
    }
    
    export default {$componentNamePascal};
    JS;
    
        echo '<div class="code-snippet">';
        echo '<code>' . htmlspecialchars($outputCode) . '</code>';
        echo '</div>';
    }
    
    function generateComponentEditCode($componentName, $parameters) {
        $componentNamePascal = ucwords($componentName).'Edit';
    
        $parametersArray = explode(',', $parameters);
        $stateCode = '';
        $setStateCode = '';
        $inputCode = '';
    
        foreach ($parametersArray as $parameter) {
            $parameter = trim($parameter);
            $parameterPascal = ucwords($parameter);
            $stateCode .= "  const [{$parameter}, set{$parameterPascal}] = useState(book.{$parameter});\n";
    
            $inputCode .= <<<HTML
          <label>{$parameterPascal}</label>
          <input
            className="input"
            type="text"
            name="{$parameter}"
            value={{$parameter}}
            onChange={handleChange}
          />\n
    HTML;
    
            $setStateCode .= "    if (name === '{$parameter}') {\n";
            $setStateCode .= "      set{$parameterPascal}(value);\n";
            $setStateCode .= "    }\n";
        }
    
        $outputCode = <<<JS
    import { useState } from 'react';
    
    function {$componentNamePascal}({ book, onSubmit }) {
    {$stateCode}
      const handleChange = (event) => {
        const { name, value } = event.target;
        {$setStateCode}
      };
    
      const handleSubmit = (event) => {
        event.preventDefault();
        const updatedBook = { ...book, {$parameters} };
        onSubmit(book.id, updatedBook);
      };
    
      return (
        <form onSubmit={handleSubmit} className="book-edit1">
    {$inputCode}
          <button className="button is-primary">Save</button>
        </form>
      );
    }
    
    export default {$componentNamePascal};
    JS;
    
        echo '<div class="code-snippet">';
        echo '<code>' . htmlspecialchars($outputCode) . '</code>';
        echo '</div>';
    }
    
    function generateApplicationCode($componentName, $parameters) {
        $componentNamePascal = ucwords($componentName);
        $code = <<<JS
      import { useState } from 'react';
      import {$componentNamePascal}Create from './components/{$componentNamePascal}Create';
      import {$componentNamePascal}List from './components/{$componentNamePascal}List';
      
      function Application() {  
        const [{$componentName}s, set{$componentName}s] = useState([]);
        const [showModal, setShowModal] = useState(false);
      
        const toggleModal = () => {
          setShowModal(!showModal);
        };
        
        const edit{$componentName}ById = (id, updated{$componentName}) => {
          const updated{$componentName}s = {$componentName}s.map(($componentName) => {
            if ($componentName.id === id) {
              return updated{$componentName};
            }
            return $componentName;
          });
          set{$componentName}s(updated{$componentName}s);
        };
      
        const delete{$componentName}ById = (id) => {
          const updated{$componentName}s = {$componentName}s.filter(($componentName) => $componentName.id !== id);
          set{$componentName}s(updated{$componentName}s);
        };
      
        const create{$componentName} = (new{$componentName}) => {
          const updated{$componentName}s = [...{$componentName}s, new{$componentName}];
          set{$componentName}s(updated{$componentName}s);
        };
      
        return (
          <div className="App">
            <{$componentNamePascal}List {$componentName}s={{$componentName}s} onDelete={delete{$componentName}ById} onEdit={edit{$componentName}ById} />
            
            <button className="add-{$componentName}-button" onClick={toggleModal}>Add {$componentName}</button>
            {showModal && (
              <div className="modal">
                <div className="modal-content">
                  <span className="close" onClick={toggleModal}>
                    &times;
                  </span>
                  <{$componentNamePascal}Create onCreate={create{$componentName}} toggleModal={toggleModal} />
                </div>
              </div>
            )}
          </div>
        );
      }
      
      export default Application;
      JS;      
      echo '<div class="code-snippet">';
      echo '<code>' . htmlspecialchars($code) . '</code>';
      echo '</div>';
      }
      
      

