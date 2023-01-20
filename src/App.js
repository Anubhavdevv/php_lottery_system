import React, { useState } from "react";

function WinnerPicker() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      // Send a post request to the backend to submit the entry
      const response = await fetch("/submit", {
        method: "POST",
        body: JSON.stringify({ name, email }),
        headers: {
          "Content-Type": "application/json",
        },
      });

      const data = await response.json();
      if (data.error) {
        alert(data.error);
      } else {
        alert("Your entry has been submitted!");
        setName("");
        setEmail("");
      }
    } catch (err) {
      console.error(err);
    }
  };

  const handlePickWinner = async () => {
    try {
      // Send a get request to the backend to pick a winner
      const response = await fetch("/pick_winner");
      const data = await response.json();
      alert(`The winner is: ${data.name} (${data.email})`);
    } catch (err) {
      console.error(err);
    }
  };

  return (
    <div>
      <form action="http://localhost:8000/PHP/server.php" onSubmit={handleSubmit}>
        <label>
          Name:
          <input
            type="text"
            value={name}
            onChange={(e) => setName(e.target.value)}
          />
        </label>
        <br />
        <label>
          Email:
          <input
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
        </label>
        <br />
        <button type="submit">Submit</button>
      </form>
      <button onClick={handlePickWinner}>Pick Winner</button>
    </div>
  );
}

export default WinnerPicker;