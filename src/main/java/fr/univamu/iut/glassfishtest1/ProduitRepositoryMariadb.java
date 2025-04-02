package fr.univamu.iut.glassfishtest1;

import java.sql.*;
import java.util.List;
import java.util.ArrayList;

public class ProduitRepositoryMariadb implements ProduitRepositoryInterface {
    protected Connection dbConnection;

    public ProduitRepositoryMariadb() {
    }

    public ProduitRepositoryMariadb(String infoConnection, String user, String pwd ) throws java.sql.SQLException, java.lang.ClassNotFoundException {
        Class.forName("org.mariadb.jdbc.Driver");
        dbConnection = DriverManager.getConnection( infoConnection, user, pwd ) ;
    }

    @Override
    public List<Produit> getProduits() {
        List<Produit> produits = new ArrayList<>();
        try {
            String query = "SELECT * FROM Produits";
            Statement stmt = dbConnection.createStatement();
            ResultSet resultSet = stmt.executeQuery(query);
            
            while (resultSet.next()) {
                Produit produit = new Produit(
                    resultSet.getInt("item_id"),
                    resultSet.getString("name"),
                    resultSet.getInt("quantity"),
                    resultSet.getInt("price")
                );
                produits.add(produit);
            }
            resultSet.close();
            stmt.close();
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }
        return produits;
    }

    @Override
    public Produit getProduitById(int id) {
        try {
            String query = "SELECT * FROM Produits WHERE item_id = ?";
            PreparedStatement stmt = dbConnection.prepareStatement(query);
            stmt.setInt(1, id);
            ResultSet resultSet = stmt.executeQuery();
            
            if (resultSet.next()) {
                return new Produit(
                    resultSet.getInt("item_id"),
                    resultSet.getString("name"),
                    resultSet.getInt("quantity"),
                    resultSet.getInt("price")
                );
            }
            resultSet.close();
            stmt.close();
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }
        return null;
    }

    @Override
    public void updateProduit(Produit produit) {

    }

    @Override
    public Produit getProduit(int id) {
        return getProduitById(id);
    }

    @Override
    public void createProduit(Produit produit) {
        try {
            String query = "INSERT INTO Produits (name, quantity, price) VALUES (?, ?, ?)";
            PreparedStatement stmt = dbConnection.prepareStatement(query);
            stmt.setString(1, produit.getName());
            stmt.setInt(2, produit.getQuantity());
            stmt.setInt(3, (int)produit.getPrice());
            stmt.executeUpdate();
            stmt.close();
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }
    }

    @Override
    public void deleteProduit(int id) {
        try {
            String query = "DELETE FROM Produits WHERE item_id = ?";
            PreparedStatement stmt = dbConnection.prepareStatement(query);
            stmt.setInt(1, id);
            stmt.executeUpdate();
            stmt.close();
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }
    }
}
