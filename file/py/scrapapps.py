import pandas as pd
import nltk
from newspaper import Article

def scrap_data(url: str) -> tuple:
	str_text = Article(url)
	str_text.download()
	str_text.parse()
	# nltk.download('punkt')
	# str_text.nlp()

	data = str_text.text
	# raw_text = views.result(data)

	return data


def get_title(url):
    gtitle = Article(url)
    gtitle.download()
    gtitle.parse()
    gtitle.title
    
    return gtitle.title