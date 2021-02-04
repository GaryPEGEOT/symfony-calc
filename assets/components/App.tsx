import React, { useState } from "react";
import Form from "./Form";

const App: React.FC = () => {
    const [result, setResult] = useState<number | null>(null);

    return (
        <div className="mt-5">
            <h1>My awesome calculator</h1>
            <Form onSubmit={setResult} />
            {null !== result && (
                <p id="operation-result" className="mt-3">
                    The result is <code>{result}</code>
                </p>
            )}
        </div>
    );
};

export default App;
