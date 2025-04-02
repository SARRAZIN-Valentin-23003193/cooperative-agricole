package fr.univamu.iut.APIPU;

import jakarta.enterprise.context.ApplicationScoped;
import jakarta.inject.Inject;
import jakarta.ws.rs.*;

@Path("/user")
@ApplicationScoped
public class UserRessource {
    @Inject
    private UserService userService;

    @GET
    @Path("/authentificate")
    @Produces("application/json")
    public boolean Authentificate(@QueryParam("mail") String mail, @QueryParam("password") String password) {
        return userService.Authentificate(mail, password);
    }
}
