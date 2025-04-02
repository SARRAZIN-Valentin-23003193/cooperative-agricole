package fr.univamu.iut.APIPU;

import java.sql.*;
import java.util.List;

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
        return List.of();
    }

    @Override
    public Produit getProduitById(int id) {
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
            String query = "INSERT INTO Produit (name, quantity, price) VALUES (?, ?, ?)";
            PreparedStatement stmt = dbConnection.prepareStatement(query);
            stmt.setString(1, produit.getName());
            stmt.setInt(2, produit.getQuantity());
            stmt.setDouble(3, produit.getPrice());
            stmt.executeUpdate();
            stmt.close();
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }
    }

    @Override
    public void deleteProduit(int id) {
        try {
            String query = "DELETE FROM Produit WHERE id = ?";
            PreparedStatement stmt = dbConnection.prepareStatement(query);
            stmt.setInt(1, id);
            stmt.executeUpdate();
            stmt.close();
        } catch (SQLException e) {
            System.err.println(e.getMessage());
        }
    }
}
