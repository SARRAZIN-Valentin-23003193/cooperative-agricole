package fr.univamu.iut.panier;

import jakarta.ws.rs.client.Client;
import jakarta.ws.rs.client.ClientBuilder;
import jakarta.ws.rs.client.Entity;
import jakarta.ws.rs.client.WebTarget;
import jakarta.ws.rs.core.MediaType;
import jakarta.ws.rs.core.Response;
import java.util.ArrayList;
import java.util.List;

public class ProduitRepositoryAPI implements ProduitRepositoryInterface{

    String url;

    public ProduitRepositoryAPI(String url) {
        this.url = url;
    }

    public void close() {}


    public Produit getProduitById(int id) {
        Produit myProduit = null;

        // création d'un client
        Client client = ClientBuilder.newClient();
        // définition de l'adresse de la ressource
        WebTarget produitResource  = client.target(url);
        // définition du point d'accès
        WebTarget produitEndpoint = produitResource.path("produit/getproduit?id="+id);
        // envoi de la requête et récupération de la réponse
        Response response = produitEndpoint.request(MediaType.APPLICATION_JSON).get();

        // si le livre a bien été trouvé, conversion du JSON en Book
        if( response.getStatus() == 200)
            myProduit = response.readEntity(Produit.class);

        // fermeture de la connexion
        client.close();
        return myProduit;
    }

    public boolean updateProduit(int id, String name, int quantity, double price) {
        boolean result = false ;
        Produit updatedProduit = new Produit(id, name, quantity, price);

        // création d'un client
        Client client = ClientBuilder.newClient();
        // définition de l'adresse de la ressource
        WebTarget produitResource  = client.target(url);
        // définition du point d'accès
        WebTarget produitEndpoint = produitResource.path("produit/updateproduit?id="+id);
        // envoi de la requête avec le livre en JSON et récupération de la réponse
        Response response = produitEndpoint.request(MediaType.APPLICATION_JSON).put( Entity.entity(updatedProduit, MediaType.APPLICATION_JSON) );

        // si la mise à jour a été faite
        if( response.getStatus() == 200)
            result = true;

        // fermeture de la connexion
        client.close();
        return result;
    }

    //public void createProduit(Produit produit);

    //public void deleteProduit(int id);
}
