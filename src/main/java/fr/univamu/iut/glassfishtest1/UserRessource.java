package fr.univamu.iut.glassfishtest1;

import jakarta.enterprise.context.ApplicationScoped;
import jakarta.inject.Inject;
import jakarta.ws.rs.*;
import jakarta.ws.rs.core.Response;

@Path("/user")
@ApplicationScoped
public class UserRessource {
    @Inject
    private UserService userService;

    @GET
    @Path("/authentificate")
    @Produces("application/json")
    public Response Authentificate(@QueryParam("mail") String mail, @QueryParam("password") String password) {
        Integer userId = userService.Authentificate(mail, password);
        if (userId != null) {
            return Response.ok(userId).build();
        } else {
            return Response.status(Response.Status.NOT_FOUND).entity("null").build();
        }
    }
}
