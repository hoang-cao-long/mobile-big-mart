package com.example.project.adapters;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.PopupMenu;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.project.R;
import com.example.project.activities.ProductDetailActivity;
import com.example.project.entities.dto.ProductDTO;
import com.example.project.services.interfaces.IProductService;
import com.example.project.utilities.GlobalApplication;

import java.util.List;

public class AdapterCart extends ArrayAdapter<ProductDTO> {
    private Context mCtx;
    private int mLayout;
    private List<ProductDTO> mProductDTOs;
    private IProductService mProductService;

    public AdapterCart(Context context, int resource, List<ProductDTO> productDTOs, IProductService productService) {
        super(context, resource, productDTOs);
        this.mCtx = context;
        this.mLayout = resource;
        this.mProductDTOs = productDTOs;
        this.mProductService = productService;
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        View item = convertView;
        if (item == null) {
            item = LayoutInflater.from(mCtx).inflate(mLayout, null);
        }

        ProductDTO productDTO = mProductDTOs.get(position);

        TextView tvProductName = item.findViewById(R.id.tvProductName);
        TextView tvProductQuantity = item.findViewById(R.id.tvProductQuantity);
        TextView tvProductPrice = item.findViewById(R.id.tvProductPrice);
        TextView tvProductPoint = item.findViewById(R.id.tvProductPoint);
        ImageView ivMenuProduct = item.findViewById(R.id.ivMenuProduct);

        ivMenuProduct.setOnClickListener(view -> showMenuEachProduct(productDTO.id, view));

        tvProductName.setText(productDTO.name + "");
        tvProductQuantity.setText(productDTO.quantity + "");
        tvProductPrice.setText(productDTO.price.shortValue() + " VND");
        tvProductPoint.setText(productDTO.point + " điểm");

        return item;
    }

    private void showMenuEachProduct(int productId, View view) {
        PopupMenu popupMenu = new PopupMenu(mCtx, view);
        popupMenu.getMenuInflater().inflate(R.menu.menu_cart, popupMenu.getMenu());
        popupMenu.setOnMenuItemClickListener(menuItem -> actionMenuItemEachProduct(productId, menuItem));
        popupMenu.show();
    }

    private boolean actionMenuItemEachProduct(int productId, MenuItem item) {
        switch (item.getItemId()) {
            case R.id.menuChangeQuantity:
                break;
            case R.id.menuDelete:
                break;
        }
        return true;
    }

    private void changeQuantity(){

    }

    private void deleteProduct(){

    }
}
