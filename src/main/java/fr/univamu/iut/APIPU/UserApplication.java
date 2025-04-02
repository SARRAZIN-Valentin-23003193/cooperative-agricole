package fr.univamu.iut.APIPU;

import jakarta.enterprise.context.ApplicationScoped;
import jakarta.enterprise.inject.Produces;
import jakarta.ws.rs.ApplicationPath;
import jakarta.ws.rs.core.Application;

@ApplicationPath("/api")
@ApplicationScoped
public class UserApplication extends Application {
    @Produces
    @DatabaseConnection
    public UserRepositoryInterface openDbConnexion() {
        UserRepositoryMariadb db = null;
        try {
            db = new UserRepositoryMariadb("jdbc:mariadb://mysql-sarrazinv2.alwaysdata.net/sarrazinv2_coop_agricole", "395474_coop_agri", "Super_Pershing");
        } catch (Exception e) {
            System.err.println(e.getMessage());
        }
        return db;
    }
}
