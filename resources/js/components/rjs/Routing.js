// resources/js/components/Routing.js
import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Routing = () => {
    const [message, setMessage] = useState('');

    useEffect(() => {
        // Call the Laravel API route
        axios.get('/uz/cabinet/form/medical')
            .then(response => {
                setMessage(response.data.message);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }, []);

    return (
        <div>
            <h1>{message}</h1>
        </div>
    );
};

export default Routing;
