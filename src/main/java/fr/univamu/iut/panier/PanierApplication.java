package fr.univamu.iut.panier;

import jakarta.enterprise.context.ApplicationScoped;
import jakarta.enterprise.inject.Disposes;
import jakarta.enterprise.inject.Produces;
import jakarta.ws.rs.ApplicationPath;
import jakarta.ws.rs.core.Application;


@ApplicationPath("/api")
@ApplicationScoped
public class PanierApplication extends Application {

    /**
     * Méthode appelée par l'API CDI pour injecter la connection à la base de données au moment de la création
     * de la ressource
     * @return un objet implémentant l'interface PanierRepositoryInterface utilisée
     *          pour accéder aux données des livres, voire les modifier
     */
    @Produces
    private PanierRepositoryInterface openDbConnection(){
        PanierRepositoryMariadb db = null;

        try{
            db = new PanierRepositoryMariadb("jdbc:mariadb://mysql-sarrazinv2.alwaysdata.net/sarrazinv2_coop_agricole", "395474_coop_agri", "Super_Pershing");
        }
        catch (Exception e){
            System.err.println(e.getMessage());
        }
        return db;
    }

    @Produces
    private ProduitRepositoryInterface connectProduitApi(){
        return new ProduitRepositoryAPI("http://localhost:8080/glassfishtest1-1.0-SNAPSHOT/api/");
    }

    /**
     * Méthode permettant de fermer la connexion à la base de données lorsque l'application est arrêtée
     * @param PanierRepo la connexion à la base de données instanciée dans la méthode @openDbConnection
     */
    private void closeDbConnection(@Disposes PanierRepositoryInterface PanierRepo ) {
        PanierRepo.close();
    }
}