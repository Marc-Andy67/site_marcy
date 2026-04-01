const express = require("express");
const app = express();

// Port du serveur
const PORT = 3000;

// Middleware pour servir des fichiers statiques (ex: dossier public)
app.use(express.static("public"));

// Route test
app.get("/health", (req, res) => {
  res.send("Serveur accessible sur le réseau ✅");
});

// IMPORTANT : écouter sur 0.0.0.0 pour exposer au réseau
app.listen(PORT, "0.0.0.0", () => {
  console.log(`Serveur accessible sur le réseau`);
  console.log(`http://localhost:${PORT}`);
});
