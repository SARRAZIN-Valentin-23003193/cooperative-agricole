package fr.univamu.iut.panier;

import java.util.*;

public interface ProduitRepositoryInterface {

    public Produit getProduitById(int id);

    public boolean updateProduit(int id, String name, int quantity, double price);

    //public void createProduit(Produit produit);

    //public void deleteProduit(int id);
}