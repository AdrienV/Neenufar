pragma solidity >=0.4.22 <0.6.0;

/// @title Help each other around the world
contract Neenufar {
    // Angel = person who give money for a Brother (project / family)
    struct Angel {
        uint weight; // poid gagné sur l'app (stars system)
        uint amount;  // montant envoyé
        address delegate; // Cette personne a envoyé de l'argent à
    }
    
    // Brother = person who help each other with money sended by Angels
    struct Brother {
        uint weight; // poid gagné sur l'app
        uint review; // review donné pour la transaction
        uint amount;  // montant envoyé
    }

}