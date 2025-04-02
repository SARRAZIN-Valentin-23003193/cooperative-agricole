package fr.univamu.iut.glassfishtest1;

import jakarta.enterprise.context.ApplicationScoped;
import jakarta.enterprise.inject.Produces;
import jakarta.ws.rs.ApplicationPath;
import jakarta.ws.rs.core.Application;

@ApplicationPath("/api")
@ApplicationScoped
public class ProduitApplication extends Application {
    @Produces
    @DatabaseConnection
    public ProduitRepositoryInterface openDbConnexion() {
        ProduitRepositoryMariadb db = null;
        try {
            db = new ProduitRepositoryMariadb("jdbc:mariadb://mysql-sarrazinv2.alwaysdata.net/sarrazinv2_coop_agricole", "395474_coop_agri", "Super_Pershing");
        } catch (Exception e) {
            System.err.println(e.getMessage());
        }
        return db;
    }
}
