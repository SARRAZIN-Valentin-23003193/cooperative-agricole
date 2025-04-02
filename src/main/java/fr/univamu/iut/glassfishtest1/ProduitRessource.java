package fr.univamu.iut.glassfishtest1;

import jakarta.enterprise.context.ApplicationScoped;
import jakarta.inject.Inject;
import jakarta.ws.rs.*;
import jakarta.ws.rs.core.Response;

import java.util.List;

@Path("/produit")
@ApplicationScoped
public class ProduitRessource {
    @Inject
    private ProduitService produitService;

    @GET
    @Path("/getproduit")
    @Produces("application/json")
    public Response getProduit(@QueryParam("id") int id) {
        Produit produit = produitService.getProduit(id);
        if (produit != null) {
            return Response.ok(produit).build();
        } else {
            return Response.status(Response.Status.NOT_FOUND).entity("Produit non trouvé").build();
        }
    }

    @GET
    @Path("/getallproduits")
    @Produces("application/json")
    public Response getAllProduits() {
        List<Produit> produits = produitService.getAllProduits();
        return Response.ok(produits).build();
    }

    @POST
    @Path("/createproduit")
    @Consumes("application/json")
    @Produces("application/json")
    public Response createProduit(Produit produit) {
        produitService.createProduit(produit);
        return Response.status(Response.Status.CREATED).entity(produit).build();
    }

    @PUT
    @Path("/updateproduit")
    @Consumes("application/json")
    @Produces("application/json")
    public Response updateProduit(@QueryParam("id") int id, Produit produit) {
        Produit existingProduit = produitService.getProduit(id);
        if (existingProduit != null) {
            produit.setId(id);
            produitService.updateProduit(produit);
            return Response.ok(produit).build();
        } else {
            return Response.status(Response.Status.NOT_FOUND).entity("Produit non trouvé").build();
        }
    }

    @DELETE
    @Path("/deleteproduit")
    @Produces("application/json")
    public Response deleteProduit(@QueryParam("id") int id) {
        Produit produit = produitService.getProduit(id);
        if (produit != null) {
            produitService.deleteProduit(id);
            return Response.ok().entity("Produit supprimé avec succès").build();
        } else {
            return Response.status(Response.Status.NOT_FOUND).entity("Produit non trouvé").build();
        }
    }
}