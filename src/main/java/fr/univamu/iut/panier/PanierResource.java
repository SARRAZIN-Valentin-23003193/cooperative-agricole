package fr.univamu.iut.panier;

import jakarta.inject.Inject;
import jakarta.ws.rs.*;
import jakarta.ws.rs.core.Response;


/**
 * Ressource associée aux livres
 * (point d'accès de l'API REST)
 */
@Path("/paniers")
public class PanierResource {

    /**
     * Service utilisé pour accéder aux données des livres et récupérer/modifier leurs informations
     */
    private PanierService service;

    /**
     * Constructeur par défaut
     */
    public PanierResource(){}

    /**
     * Constructeur permettant d'initialiser le service avec une interface d'accès aux données
     * @param PanierRepo objet implémentant l'interface d'accès aux données
     */
    public @Inject PanierResource(PanierRepositoryInterface PanierRepo, ProduitRepositoryInterface ProduitRepo ){
        this.service = new PanierService( PanierRepo, ProduitRepo ) ;
    }

    /**
     * Constructeur permettant d'initialiser le service d'accès aux livres
     */
    public PanierResource( PanierService service ){
        this.service = service;
    }

    /**
     * Enpoint permettant de publier de tous les livres enregistrés
     * @return la liste des livres (avec leurs informations) au format JSON
     */
    @GET
    @Produces("application/json")
    public String getAllPaniers() {
        return service.getAllPaniersJSON();
    }

    /**
     * Endpoint permettant de publier les informations d'un livre dont la référence est passée paramètre dans le chemin
     * @param basket_id référence du livre recherché
     * @return les informations du livre recherché au format JSON
     */
    @GET
    @Path("{basket_id}")
    @Produces("application/json")
    public String getPanier( @PathParam("basket_id") String basket_id){

        String result = service.getPanierJSON(basket_id);

        // si le livre n'a pas été trouvé
        if( result == null )
            throw new NotFoundException();

        return result;
    }

    @GET
    @Path("{basket_id}/produits")
    @Produces("application/json")
    public String getAllProduitsByPanier( @PathParam("basket_id") String basket_id){

        String result = service.getAllProduitByPanierJSON(basket_id);

        // si le livre n'a pas été trouvé
        if( result == null )
            throw new NotFoundException();

        return result;
    }

    /**
     * Endpoint permettant de mettre à jours le statut d'un livre uniquement
     * (la requête patch doit fournir le nouveau statut sur livre, les autres informations sont ignorées)
     * @param basket_id la référence du livre dont il faut changer le statut
     * @param Panier le livre transmis en HTTP au format JSON et convertit en objet Panier
     * @return une réponse "updated" si la mise à jour a été effectuée, une erreur NotFound sinon
     */
    @PUT
    @Path("{basket_id}")
    @Consumes("application/json")
    public Response updatePanier(@PathParam("basket_id") String basket_id, Panier Panier ){

        // si le livre n'a pas été trouvé
        if( ! service.updatePanier(basket_id, Panier) )
            throw new NotFoundException();
        else
            return Response.ok("updated").build();
    }
}
