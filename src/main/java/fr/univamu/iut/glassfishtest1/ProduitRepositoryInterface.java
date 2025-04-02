package fr.univamu.iut.glassfishtest1;

import java.util.*;

public interface ProduitRepositoryInterface {

    public List<Produit> getProduits();

    public Produit getProduitById(int id);

    public void updateProduit(Produit produit);

    public Produit getProduit(int id);

    public void createProduit(Produit produit);

    public void deleteProduit(int id);
}
