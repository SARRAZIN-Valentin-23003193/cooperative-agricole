package com.example.commande;

import jakarta.json.bind.Jsonb;
import jakarta.json.bind.JsonbBuilder;
import java.util.ArrayList;


/**
 * Classe utilisée pour récupérer les informations nécessaires à la ressource
 * (permet de dissocier ressource et mode d'éccès aux données)
 */
public class CommandeService {

    /**
     * Objet permettant d'accéder au dépôt où sont stockées les informations sur les livres
     */
    protected CommandeRepositoryInterface CommandeRepo ;

    /**
     * Constructeur permettant d'injecter l'accès aux données
     * @param CommandeRepo objet implémentant l'interface d'accès aux données
     */
    public  CommandeService( CommandeRepositoryInterface CommandeRepo) {
        this.CommandeRepo = CommandeRepo;
    }

    /**
     * Méthode retournant les informations sur les livres au format JSON
     * @return une chaîne de caractère contenant les informations au format JSON
     */
    public String getAllCommandesJSON(){

        ArrayList<Commande> allCommandes = CommandeRepo.getAllCommandes();

        // création du json et conversion de la liste de livres
        String result = null;
        try( Jsonb jsonb = JsonbBuilder.create()){
            result = jsonb.toJson(allCommandes);
        }
        catch (Exception e){
            System.err.println( e.getMessage() );
        }

        return result;
    }

    /**
     * Méthode retournant au format JSON les informations sur un livre recherché
     * @param command_id la référence du livre recherché
     * @return une chaîne de caractère contenant les informations au format JSON
     */
    public String getCommandeJSON( String command_id ){
        String result = null;
        Commande myCommande = CommandeRepo.getCommande(command_id                                                                                                                                                                                                                                                                                );

        // si le livre a été trouvé
        if( myCommande != null ) {

            // création du json et conversion du livre
            try (Jsonb jsonb = JsonbBuilder.create()) {
                result = jsonb.toJson(myCommande);
            } catch (Exception e) {
                System.err.println(e.getMessage());
            }
        }
        return result;
    }

    /**
     * Méthode permettant de mettre à jours les informations d'un livre
     * @param command_id référence du livre à mettre à jours
     * @param Commande les nouvelles infromations a été utiliser
     * @return true si le livre a pu être mis à jours
     */
    public boolean updateCommande(String command_id, Commande Commande) {
        return CommandeRepo.updateCommande(command_id, Commande.pickup_location, Commande.withdrawal_date);
    }
}