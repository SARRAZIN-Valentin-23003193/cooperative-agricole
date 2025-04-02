package fr.univamu.iut.panier;

/**
 * Classe représentant un livre
 */
public class PanierWithProduits {

    protected String id;
    /**
     * Référence du livre
     */
    protected String basket_id;

    /**
     * titre du livre
     */
    protected String item_id;

    /**
     * Auteurs du livre
     */
    protected String quantity;

    /**
     * Statut du livre
     * ('r' pour réservé, 'e' pour emprunté, et 'd' pour disponible)
     */
    protected String unit;

    /**c
     * Constructeur par défaut
     */
    public PanierWithProduits() {
    }

    /**
     * Constructeur de livre
     * @param id id
     * @param basket_id référence du livre
     * @param item_id titre du livre
     * @param quantity auteurs du livre
     * @param unit prix du panier
     */
    public PanierWithProduits(String id, String basket_id, String item_id, String quantity, String unit){
        this.id = id;
        this.basket_id = basket_id;
        this.item_id = item_id;
        this.quantity = quantity;
        this.unit = unit;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getUnit() {
        return unit;
    }

    public void setUnit(String unit) {
        this.unit = unit;
    }

    public String getQuantity() {
        return quantity;
    }

    public void setQuantity(String quantity) {
        this.quantity = quantity;
    }

    public String getItem_id() {
        return item_id;
    }

    public void setItem_id(String item_id) {
        this.item_id = item_id;
    }

    public String getBasket_id() {
        return basket_id;
    }

    public void setBasket_id(String basket_id) {
        this.basket_id = basket_id;
    }

    @Override
    public String toString() {
        return "PanierWithProduits{" +
                "id='" + id + '\'' +
                ", basket_id='" + basket_id + '\'' +
                ", item_id='" + item_id + '\'' +
                ", quantity='" + quantity + '\'' +
                ", unit='" + unit + '\'' +
                '}';
    }
}