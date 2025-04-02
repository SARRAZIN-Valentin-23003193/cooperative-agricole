package com.example.commande;

import java.util.*;

/**
 * Interface d'accès aux données
 */
public interface CommandeRepositoryInterface {

    /**
     *  Méthode fermant le dépôt où sont stockées les informations sur les livres
     */
    public void close();

    /**
     * Méthode retournant le livre dont la référence est passée en paramètre
     * @param command_id identifiant du livre recherché
     * @return un objet Panier représentant le livre recherché
     */
    public Commande getCommande( String command_id );

    /**
     * Méthode retournant la liste des livres
     * @return une liste d'objets livres
     */
    public ArrayList<Commande> getAllCommandes() ;

    /**
     * Méthode permettant de mettre à jours un livre enregistré
     * @param command_id identifiant du livre à mettre à jours
     * @param pickup_location nouveau titre du livre
     * @param withdrawal_date nouvelle liste d'auteurs
     * @return true si le livre existe et la mise à jours a été faite, false sinon
     */
    public boolean updateCommande(String command_id, String pickup_location, String withdrawal_date);
}