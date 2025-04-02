package com.example.commande;

import jakarta.enterprise.context.ApplicationScoped;
import jakarta.enterprise.inject.Disposes;
import jakarta.enterprise.inject.Produces;
import jakarta.ws.rs.ApplicationPath;
import jakarta.ws.rs.core.Application;


@ApplicationPath("/api")
@ApplicationScoped
public class CommandeApplication extends Application {

    /**
     * Méthode appelée par l'API CDI pour injecter la connection à la base de données 
     * @return un objet implémentant l'interface PanierRepositoryInterface utilisée
     *          pour accéder aux données des livres, voire les modifier
     */
    @Produces
    private CommandeRepositoryInterface openDbConnection(){
        CommandeRepositoryMariadb db = null;

        try{
            db = new   CommandeRepositoryMariadb("jdbc:mariadb://mysql-sarrazinv2.alwaysdata.net/sarrazinv2_coop_agricole", "395474_coop_agri", "Super_Pershing");
        }
        catch (Exception e){
            System.err.println(e.getMessage());
        }
        return db;
    }

    /**
     * Méthode permettant de fermer la connexion à la base de données lorsque l'application est arrêtée
     * @param CommandeRepo la connexion à la base de données instanciée dans la méthode @openDbConnection
     */
    private void closeDbConnection(@Disposes CommandeRepositoryInterface CommandeRepo ) {
        CommandeRepo.close();
    }
}