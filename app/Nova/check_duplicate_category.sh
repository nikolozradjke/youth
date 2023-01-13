for dir in ./*     # list files in the form "/tmp/dirname/"
do
    dir=${dir%*/}      # remove the trailing "/"
    a=$(cat ${dir} | grep -c '$category')
    if [ "${a}" -gt 1 ];then
        echo ${dir##*/}    # print if duplicate category exists
    fi
done