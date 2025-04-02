package com.example.commande;

import jakarta.inject.Inject;
import jakarta.ws.rs.*;
import jakarta.ws.rs.core.Response;


/**
 * Ressource associée aux livres
 * (point d'accès de l'API REST)
 */
@Path("/commandes")
public class CommandeResource {

    /**
     * Service utilisé pour accéder aux données des livres et récupérer/modifier leurs informations
     */
    private CommandeService service;

    /**
     * Constructeur par défaut
     */
    public CommandeResource(){}

    /**
     * Constructeur permettant d'initialiser le service avec une interface d'accès aux données
     * @param CommandeRepo objet implémentant l'interface d'accès aux données
     */
    public @Inject CommandeResource(CommandeRepositoryInterface CommandeRepo ){
        this.service = new CommandeService( CommandeRepo) ;
    }

    /**
     * Constructeur permettant d'initialiser le service d'accès aux livres
     */
    public CommandeResource( CommandeService service ){
        this.service = service;
    }

    /**
     * Enpoint permettant de publier de tous les livres enregistrés
     * @return la liste des livres (avec leurs informations) au format JSON
     */
    @GET
    @Produces("application/json")
    public String getAllCommandes() {
        return service.getAllCommandesJSON();
    }

    /**
     * Endpoint permettant de publier les informations d'un livre dont la référence est passée paramètre dans le chemin
     * @param command_id référence du livre recherché
     * @return les informations du livre recherché au format JSON
     */
    @GET
    @Path("{command_id}")
    @Produces("application/json")
    public String getPanier( @PathParam("command_id") String command_id){

        String result = service.getCommandeJSON(command_id);

        // si le livre n'a pas été trouvé
        if( result == null )
            throw new NotFoundException();

        return result;
    }

    /**
     * Endpoint permettant de mettre à jours le statut d'un livre uniquement
     * (la requête patch doit fournir le nouveau statut sur livre, les autres informations sont ignorées)
     * @param command_id la référence du livre dont il faut changer le statut
     * @param Commande le livre transmis en HTTP au format JSON et convertit en objet Panier
     * @return une réponse "updated" si la mise à jour a été effectuée, une erreur NotFound sinon
     */
    @PUT
    @Path("{command_id}")
    @Consumes("application/json")
    public Response updateCommande(@PathParam("command_id") String command_id, Commande Commande ){

        // si le livre n'a pas été trouvé
        if( ! service.updateCommande(command_id, Commande) )
            throw new NotFoundException();
        else
            return Response.ok("updated").build();
    }
}