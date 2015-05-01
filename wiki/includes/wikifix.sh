for fl in *.php; do
mv $fl $fl.old
sed 's/Namespace::/MWNamespace::/g' $fl.old > $fl
done
