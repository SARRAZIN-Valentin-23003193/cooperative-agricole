package fr.univamu.iut.panier;

import jakarta.json.bind.Jsonb;
import jakarta.json.bind.JsonbBuilder;
import java.util.ArrayList;


/**
 * Classe utilisée pour récupérer les informations nécessaires à la ressource
 * (permet de dissocier ressource et mode d'éccès aux données)
 */
public class PanierService {

    /**
     * Objet permettant d'accéder au dépôt où sont stockées les informations sur les livres
     */
    protected PanierRepositoryInterface PanierRepo;

    protected ProduitRepositoryInterface ProduitRepo;

    /**
     * Constructeur permettant d'injecter l'accès aux données
     * @param PanierRepo objet implémentant l'interface d'accès aux données
     */
    public  PanierService( PanierRepositoryInterface PanierRepo, ProduitRepositoryInterface ProduitRepo) {
        this.PanierRepo = PanierRepo;
        this.ProduitRepo = ProduitRepo;
    }

    /**
     * Méthode retournant les informations sur les livres au format JSON
     * @return une chaîne de caractère contenant les informations au format JSON
     */
    public String getAllPaniersJSON(){

        ArrayList<Panier> allPaniers = PanierRepo.getAllPaniers();

        // création du json et conversion de la liste de livres
        String result = null;
        try( Jsonb jsonb = JsonbBuilder.create()){
            result = jsonb.toJson(allPaniers);
        }
        catch (Exception e){
            System.err.println( e.getMessage() );
        }

        return result;
    }

    /**
     * Méthode retournant au format JSON les informations sur un livre recherché
     * @param basket_id la référence du livre recherché
     * @return une chaîne de caractère contenant les informations au format JSON
     */
    public String getPanierJSON( String basket_id ){
        String result = null;
        Panier myPanier = PanierRepo.getPanier(basket_id                                                                                                                                                                                                                                                                                );

        // si le livre a été trouvé
        if( myPanier != null ) {

            // création du json et conversion du livre
            try (Jsonb jsonb = JsonbBuilder.create()) {
                result = jsonb.toJson(myPanier);
            } catch (Exception e) {
                System.err.println(e.getMessage());
            }
        }
        return result;
    }

    public String getAllProduitByPanierJSON( String basket_id ){
        String result = null;
        PanierWithProduits myPanier = PanierRepo.getAllProduitsByPanier(basket_id                                                                                                                                                                                                                                                                                );

        // si le livre a été trouvé
        if( myPanier != null ) {

            // création du json et conversion du livre
            try (Jsonb jsonb = JsonbBuilder.create()) {
                result = jsonb.toJson(myPanier);
            } catch (Exception e) {
                System.err.println(e.getMessage());
            }
        }
        return result;
    }


/**
     * Méthode permettant de mettre à jours les informations d'un livre
     * @param basket_id référence du livre à mettre à jours
     * @param Panier les nouvelles infromations a été utiliser
     * @return true si le livre a pu être mis à jours
     */
    public boolean updatePanier(String basket_id, Panier Panier) {
        return PanierRepo.updatePanier(basket_id, Panier.name, Panier.quantity, Panier.price);
    }
}