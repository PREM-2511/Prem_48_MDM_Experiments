import React from 'react';
import Counter from './Counter'; // Import our new component

function App() {
  return (
    <div style={{ fontFamily: 'Arial', textAlign: 'center', marginTop: '50px' }}>
      <h1>Experiment 9: ReactJS Hooks</h1>
      
      {/* Here we render the Counter component. 
        We are passing two PROPS to it: 'title' and 'initialCount'.
      */}
      <Counter title="My Custom Counter" initialCount={0} />
      
    </div>
  );
}

export default App;