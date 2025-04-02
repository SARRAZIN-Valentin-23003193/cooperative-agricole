package fr.univamu.iut.glassfishtest1;

import java.sql.*;

public class UserRepositoryMariadb implements UserRepositoryInterface {
    protected Connection dbConnection;

    public UserRepositoryMariadb() {
    }

    public UserRepositoryMariadb(String infoConnection, String user, String pwd ) throws java.sql.SQLException, java.lang.ClassNotFoundException {
        Class.forName("org.mariadb.jdbc.Driver");
        dbConnection = DriverManager.getConnection( infoConnection, user, pwd ) ;
    }

    @Override
    public Integer Authentificate(String mail, String password) {
        try {
            String sql = "SELECT user_id FROM Utilisateurs WHERE email = ? AND mdp = ?";
            PreparedStatement statement = dbConnection.prepareStatement(sql);
            statement.setString(1, mail);
            statement.setString(2, password);
            ResultSet resultSet = statement.executeQuery();

            if (resultSet.next()) {
                Integer userId = resultSet.getInt("user_id");
                resultSet.close();
                statement.close();
                return userId;
            }
            resultSet.close();
            statement.close();
            return null;
        } catch (SQLException e) {
            System.err.println(e.getMessage());
            return null;
        }
    }
}
