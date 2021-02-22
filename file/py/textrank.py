import re
from pprint import pprint

import numpy as np
import nltk
from nltk import sent_tokenize, word_tokenize

from nltk.cluster.util import cosine_distance
from nltk.corpus import stopwords

import pandas as pd


MULTIPLE_WHITESPACE_PATTERN = re.compile(r"\s+", re.UNICODE)

def normalize_whitespace(text):
    return MULTIPLE_WHITESPACE_PATTERN.sub(_replace_whitespace, text)

def _replace_whitespace(match):
    text = match.group()
    if "\n" in text or "\r" in text or "\\n" in text:
        return "\n"
    else:
        return " "

def is_blank(string):
    return not string or string.isspace()


class GetMatrix:
    
    def get_symmetric_matrix(matrix):
        """
        Get Symmetric matrix
        :param matrix:
        :return: matrix
        """
        return matrix + matrix.T - np.diag(matrix.diagonal())

    def core_cosine_similarity(vector1, vector2):
        """
        measure cosine similarity between two vectors
        :param vector1:
        :param vector2:
        :return: 0 < cosine similarity value < 1
        """
        return 1 - cosine_distance(vector1, vector2)


class TextRankSentences():
    
    def __init__(self):
        self.damping = 0.85  # damping coefficient, usually is .85
        self.min_diff = 1e-5  # convergence threshold
        self.steps = 100  # iteration steps
        self.text_str = None
        self.sentences = None
        self.pr_vector = None

    def _sentence_similarity(self, sent1, sent2, stop_words=None):
#         if stopwords is None:
#             stopwords = []
        
        stoplist = []
        stoplist = set(stopwords.words('indonesian'))
        sent1 = [w.lower() for w in sent1]
        sent2 = [w.lower() for w in sent2]

        all_words = list(set(sent1 + sent2))

        vector1 = [0] * len(all_words)
        vector2 = [0] * len(all_words)

        # build the vector for the first sentence
        for w in sent1:
            if w in stoplist:
                continue
            vector1[all_words.index(w)] += 1

        # build the vector for the second sentence
        for w in sent2:
            if w in stoplist:
                continue
            vector2[all_words.index(w)] += 1

        return GetMatrix.core_cosine_similarity(vector1, vector2)

    def _build_similarity_matrix(self, sentences, stop_words=None):
        # create an empty similarity matrix
        sm = np.zeros([len(sentences), len(sentences)])

        for idx1 in range(len(sentences)):
            for idx2 in range(len(sentences)):
                if idx1 == idx2:
                    continue

                sm[idx1][idx2] = self._sentence_similarity(sentences[idx1], sentences[idx2], stop_words)

        # Get Symmeric matrix
        sm = GetMatrix.get_symmetric_matrix(sm)

        # Normalize matrix by column
        norm = np.sum(sm, axis=0)
        sm_norm = np.divide(sm, norm, where=norm != 0)  # this is to ignore the 0 element in norm

        return sm_norm

    def _run_page_rank(self, similarity_matrix):

        pr_vector = np.array([1] * len(similarity_matrix))

        # Iteration
        previous_pr = 0
        for epoch in range(self.steps):
            pr_vector = (1 - self.damping) + self.damping * np.matmul(similarity_matrix, pr_vector)
            if abs(previous_pr - sum(pr_vector)) < self.min_diff:
                break
            else:
                previous_pr = sum(pr_vector)

        return pr_vector

    def _get_sentence(self, index):

        try:
            return self.sentences[index]
        except IndexError:
            return ""

    def get_top_sentences(self, number=5):

        top_sentences = {}

        if self.pr_vector is not None:

            sorted_pr = np.argsort(self.pr_vector)
            sorted_pr = list(sorted_pr)
            sorted_pr.reverse()

            index = 0

            for epoch in range(number):
                print (str(sorted_pr[index]) + " : " + str(self.pr_vector[sorted_pr[index]]))
                sent = self.sentences[sorted_pr[index]]
                sent = normalize_whitespace(sent)
                top_sentences[sent] = self.pr_vector[sorted_pr[index]]
                index += 1
        

        return top_sentences
    
    def analyze(self, text):

        # Buat muslim or.id pakai lower langsung
        self.text_str = text.lower()

        # self.text_str = str(text)
        # self.raw_text = self.text_str.lower()
        self.sentences = sent_tokenize(self.text_str)

        tokenized_sentences = [word_tokenize(sent) for sent in self.sentences]
        
        stop_words = stopwords.words('indonesian')
        sen_new = [sen for sen in tokenized_sentences if sen not in stop_words]
                
        similarity_matrix = self._build_similarity_matrix(sen_new, stop_words)


        self.pr_vector = self._run_page_rank(similarity_matrix)
        