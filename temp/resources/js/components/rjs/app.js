// resources/js/components/app.jsx
import React from 'react';
import ReactDOM from 'react-dom';
import HelloWorld from './Routing.js';

const App = () => {
    return (
        <div>
            <Routing />
        </div>
    );
};

ReactDOM.render(<App />, document.getElementById('app'));
