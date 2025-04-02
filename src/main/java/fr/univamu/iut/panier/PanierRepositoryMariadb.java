package fr.univamu.iut.panier;

import java.io.Closeable;
import java.sql.*;
import java.util.ArrayList;

/**
 * Classe permettant d'accèder aux livres stockés dans une base de données Mariadb
 */
public class PanierRepositoryMariadb   implements PanierRepositoryInterface, Closeable {

    /**
     * Accès à la base de données (session)
     */
    protected Connection dbConnection ;

    /**
     * Constructeur de la classe
     * @param infoConnection chaîne de caractères avec les informations de connexion
     *                       (p.ex. jdbc:mariadb://mysql-[compte].alwaysdata.net/[compte]_library_db
     * @param user chaîne de caractères contenant l'identifiant de connexion à la base de données
     * @param pwd chaîne de caractères contenant le mot de passe à utiliser
     */
    public PanierRepositoryMariadb(String infoConnection, String user, String pwd ) throws java.sql.SQLException, java.lang.ClassNotFoundException {
        Class.forName("org.mariadb.jdbc.Driver");
        dbConnection = DriverManager.getConnection( infoConnection, user, pwd ) ;
    }

    @Override
    public void close() {
        try{
            dbConnection.close();
        }
        catch(SQLException e){
            System.err.println(e.getMessage());
        }
    }

    @Override
    public Panier getPanier(String basket_id) {

        Panier selectedPanier = null;

        String query = "SELECT * FROM Paniers WHERE basket_id=?";

        // construction et exécution d'une requête préparée
        try ( PreparedStatement ps = dbConnection.prepareStatement(query) ){
            ps.setString(1, basket_id);

            // exécution de la requête
            ResultSet result = ps.executeQuery();

            // récupération du premier (et seul) tuple résultat
            // (si la référence du livre est valide)
            if( result.next() )
            {
                String name = result.getString("name");
                String quantity = result.getString("quantity");
                String price = result.getString("price");

                // création et initialisation de l'objet Panier
                selectedPanier = new Panier(basket_id, name, quantity, price);
            }
        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
        return selectedPanier;
    }

    @Override
    public ArrayList<Panier> getAllPaniers() {
        ArrayList<Panier> listPaniers ;

        String query = "SELECT * FROM Paniers";

        // construction et exécution d'une requête préparée
        try ( PreparedStatement ps = dbConnection.prepareStatement(query) ){
            // exécution de la requête
            ResultSet result = ps.executeQuery();

            listPaniers = new ArrayList<>();

            // récupération du premier (et seul) tuple résultat
            while ( result.next() )
            {
                String basket_id = result.getString("basket_id");
                String name = result.getString("name");
                String quantity = result.getString("quantity");
                String price = result.getString("price");

                // création du livre courant
                Panier currentPanier = new Panier(basket_id, name, quantity, price);

                listPaniers.add(currentPanier);
            }
        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
        return listPaniers;
    }

    @Override
    public boolean updatePanier(String basket_id, String name, String quantity, String price) {
        String query = "UPDATE Paniers SET name=?, quantity=?, price=?  where basket_id=?";
        int nbRowModified = 0;

        // construction et exécution d'une requête préparée
        try ( PreparedStatement ps = dbConnection.prepareStatement(query) ){
            ps.setString(1, name);
            ps.setString(2, quantity);
            ps.setString(3, price);
            ps.setString(4, basket_id);

            // exécution de la requête
            nbRowModified = ps.executeUpdate();
        } catch (SQLException e) {
            throw new RuntimeException(e);
        }

        return ( nbRowModified != 0 );
    }

    public PanierWithProduits getAllProduitsByPanier (String basket_id) {

        PanierWithProduits selectedPanier = null;

        String query = "SELECT * FROM Produits_Paniers WHERE basket_id=?";

        // construction et exécution d'une requête préparée
        try ( PreparedStatement ps = dbConnection.prepareStatement(query) ){
            ps.setString(1, basket_id);

            // exécution de la requête
            ResultSet result = ps.executeQuery();

            // récupération du premier (et seul) tuple résultat
            // (si la référence du livre est valide)
            if( result.next())
            {
                String id = result.getString("id");
                String item_id = result.getString("item_id");
                String quantity = result.getString("quantity");
                String unit = result.getString("unit");

                // création et initialisation de l'objet Panier
                selectedPanier = new PanierWithProduits(id, basket_id, item_id, quantity, unit);
            }
        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
        return selectedPanier;
    }
}