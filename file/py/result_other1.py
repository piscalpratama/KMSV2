import sys
import json

import scrapapps
import scrapping
from textrank import TextRankSentences
import preprocessing
import summ
import textrankkeyword
import bss4

url = sys.argv[1]

#url = request.POST.get('web_link', None)
web_link = scrapapps.scrap_data(url)

#Get Title
judul = scrapping.get_title(url)

raw_text = str(web_link)

# Preprocessing View
lower = preprocessing.text_lowercase(str(web_link))
rnumber = preprocessing.remove_numbers(lower)
white_space = preprocessing.remove_whitespace(rnumber)
stopword_list = preprocessing.remove_stopwords(white_space)

new_sentence = ' '.join(stopword_list)
stagging = preprocessing.stagging_text(new_sentence)

stop_plus = preprocessing.stopword_plus(new_sentence)
kalimat = ' '.join(stop_plus)

stemer = preprocessing.steman(new_sentence)


textrank = TextRankSentences()
# text = textrank.analyze(str(new_sentence))
# text = textrank.get_top_sentences(5)

# Dari Gensim
# text = textrankkeyword.summarizeTextrank(new_sentence)

text = summ.summarize(new_sentence)

# View Similarity Matriks
sim_mat = textrank._build_similarity_matrix(stagging)

#View Hasil Perhitungan Textrank
top_rank = textrank._run_page_rank(sim_mat)

result = textrank._run_page_rank(sim_mat)

# Clean Hasil
ringkasan = preprocessing.remove_punctuation(text)

# Keyword Ekstrasi
keyword = textrankkeyword.keywordTextrank(kalimat).split('\n')



# Panjang Plaintext
len_raw = len(str(web_link))

# Jumlah Text
len_text = len(str(text))

# Jumlah Kalimat
len_kalimat = len(stagging)

#Presentase Reduce
presentase = round(((len_text/len_raw)*100))


# keyphrases = textrankkeyword.extract_key_phrases(raw_text)

data = {
    'raw_text' : raw_text,
    'url' : url,
    'judul' : judul,
    'ringkasan':ringkasan,
    'text':text,
    'len_raw':len_raw,
    'len_text':len_text,
    'len_kalimat':len_kalimat,
    'stagging':stagging,
    'new_sentence':new_sentence,
    # 'sim_mat':sim_mat,
    # 'result':result,
    'presentase':presentase,
    'keyword':'-',
}

print(json.dumps(data))