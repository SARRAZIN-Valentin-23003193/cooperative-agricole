package fr.univamu.iut.panier;

import java.util.*;

/**
 * Interface d'accès aux données des livres
 */
public interface PanierRepositoryInterface {

    /**
     *  Méthode fermant le dépôt où sont stockées les informations sur les livres
     */
    public void close();

    /**
     * Méthode retournant le livre dont la référence est passée en paramètre
     * @param basket_id identifiant du livre recherché
     * @return un objet Panier représentant le livre recherché
     */
    public Panier getPanier( String basket_id );

    /**
     * Méthode retournant la liste des livres
     * @return une liste d'objets livres
     */
    public ArrayList<Panier> getAllPaniers() ;

    /**
     * Méthode permettant de mettre à jours un livre enregistré
     * @param basket_id identifiant du livre à mettre à jours
     * @param name nouveau titre du livre
     * @param quantity nouvelle liste d'auteurs
     * @param price nouveau status du livre
     * @return true si le livre existe et la mise à jours a été faite, false sinon
     */
    public boolean updatePanier(String basket_id, String name, String quantity, String price);

    public PanierWithProduits getAllProduitsByPanier(String basket_id);
}